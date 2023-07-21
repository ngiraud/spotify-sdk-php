<?php

namespace Spotify;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use Spotify\Helpers\Arr;

class Factory
{
    use MakesHttpRequests;

    protected static string $endpoint = 'https://api.spotify.com/v1';

    protected static string $authEndpoint = 'https://accounts.spotify.com';

    /**
     * The Access Token for the requests.
     */
    protected ?string $accessToken = null;

    /**
     * The HTTP client for the requests.
     */
    protected ?ClientInterface $httpClient = null;

    /**
     * The base URI for the requests.
     */
    protected ?string $baseUri = null;

    /**
     * The HTTP headers for the requests.
     *
     * @var array<string, string>
     */
    protected array $headers = [];

    public function __construct(?ClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Sets the access token for the requests.
     */
    public function withAccessToken(string $accessToken): self
    {
        $this->accessToken = trim($accessToken);

        return $this;
    }

    /**
     * Sets the HTTP client for the requests.
     */
    public function withHttpClient(ClientInterface $httpClient): self
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * Sets the base URI for the requests.
     * If no URI is provided the factory will use the default Spotify API URI.
     */
    public function withBaseUri(string $baseUri): self
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    /**
     * Adds a custom HTTP header to the requests.
     */
    public function withHttpHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Prepare the HTTP client for the future requests
     */
    public function prepareHttpClient(): self
    {
        if ($this->accessToken !== null) {
            $this->headers = [
                ...$this->headers,
                ...['Authorization' => "Bearer {$this->accessToken}"],
            ];
        }

        if (! Arr::exists($this->headers, 'Accept')) {
            $this->headers['Accept'] = 'application/json';
        }

        if (! Arr::exists($this->headers, 'Content-Type')) {
            $this->headers['Content-Type'] = 'application/json';
        }

        return $this->withHttpClient(
            new GuzzleClient([
                'http_errors' => false,
                'base_uri' => sprintf('%s/', $this->baseUri ?: self::$endpoint),
                'headers' => $this->headers,
            ])
        );
    }

    /**
     * Authenticates with the basic flow. Will request to get an access token.
     */
    public function authenticateBasic(string $clientId, string $clientSecret): self
    {
        // We keep the current headers and base uri
        $endpointHeaders = $this->headers;
        $baseUri = $this->baseUri;

        $credentials = base64_encode(implode(':', [$clientId, $clientSecret]));

        $accessToken = $this->requestBasicAccessToken($credentials);

        // We replace the headers and base uri with the previous ones
        $this->headers = $endpointHeaders;
        $this->baseUri = $baseUri;

        return $this->withAccessToken($accessToken);
    }

    /**
     * Creates a new Spotify Client.
     */
    public function make(): Client
    {
        return new Client($this->prepareHttpClient());
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    protected function requestBasicAccessToken(string $credentials): string
    {
        // We prepare the client for basic authentication and request the API to get an access token
        $response = $this->withHttpHeader('Authorization', "Basic {$credentials}")
            ->withHttpHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withBaseUri(self::$authEndpoint)
            ->prepareHttpClient()
            ->request('post', 'api/token', ['grant_type' => 'client_credentials'], 'form_params');

        return Arr::get($response, 'access_token');
    }
}
