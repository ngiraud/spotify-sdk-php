<?php

namespace Spotify;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use Spotify\Exceptions\AccessTokenRequiredException;
use Spotify\Exceptions\UnableToAuthenticateException;
use Spotify\Helpers\Arr;
use Spotify\Resources\Albums;
use Spotify\Resources\Artists;
use Spotify\Resources\Audiobooks;
use Spotify\Resources\Categories;
use Spotify\Resources\Episodes;
use Spotify\Resources\Genres;
use Spotify\Resources\Markets;
use Spotify\Resources\Player;
use Spotify\Resources\Playlists;
use Spotify\Resources\Shows;
use Spotify\Resources\Tracks;
use Spotify\Resources\Users;
use Spotify\SingleObjects\Search;

class Client
{
    use MakesHttpRequests;

    protected static string $endpoint = 'https://api.spotify.com/v1';

    protected static string $authEndpoint = 'https://accounts.spotify.com/api/token/';

    public function __construct(
        protected ?string $accessToken = null,
        protected ?ClientInterface $client = null
    ) {
        if (is_null($this->accessToken)) {
            throw new AccessTokenRequiredException();
        }

        $this->client ??= new GuzzleClient([
            'http_errors' => false,
            'base_uri' => self::$endpoint.'/',
            'headers' => [
                'Authorization' => "Bearer {$this->accessToken}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function accessToken(): string
    {
        return $this->accessToken;
    }

    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function endpoint(): string
    {
        return self::$endpoint;
    }

    public function client(): ?ClientInterface
    {
        return $this->client;
    }

    /**
     * Get Spotify catalog information about albums, artists, playlists, tracks, shows, episodes or audiobooks that match a keyword string.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/search
     *
     * @param  string|array<string>  $type
     * @param  array<string|integer>  $payload
     */
    public function search(string $q, string|array $type, array $payload = []): Search
    {
        return new Search(
            (array) $this->get('search', ['q' => $q, 'type' => implode(',', (array) $type), ...$payload])
        );
    }

    /**
     * Manages Albums endpoints
     */
    public function albums(): Albums
    {
        return new Albums($this);
    }

    /**
     * Manages Artists endpoints
     */
    public function artists(): Artists
    {
        return new Artists($this);
    }

    /**
     * Manages Audiobooks endpoints
     */
    public function audiobooks(): Audiobooks
    {
        return new Audiobooks($this);
    }

    /**
     * Manages Categories endpoints
     */
    public function categories(): Categories
    {
        return new Categories($this);
    }

    /**
     * Manages Episodes endpoints
     */
    public function episodes(): Episodes
    {
        return new Episodes($this);
    }

    /**
     * Manages Genres endpoints
     */
    public function genres(): Genres
    {
        return new Genres($this);
    }

    /**
     * Manages Markets endpoints
     */
    public function markets(): Markets
    {
        return new Markets($this);
    }

    /**
     * Manages Player endpoints
     */
    public function player(): Player
    {
        return new Player($this);
    }

    /**
     * Manages Playlists endpoints
     */
    public function playlists(): Playlists
    {
        return new Playlists($this);
    }

    /**
     * Manages Shows endpoints
     */
    public function shows(): Shows
    {
        return new Shows($this);
    }

    /**
     * Manages Tracks endpoints
     */
    public function tracks(): Tracks
    {
        return new Tracks($this);
    }

    /**
     * Manages Users endpoints
     */
    public function users(): Users
    {
        return new Users($this);
    }

    /**
     * Authenticate with Client Credentials flow
     *
     * @see https://developer.spotify.com/documentation/web-api/tutorials/client-credentials-flow
     */
    public static function makeWithClientCredentials(string $clientId, string $clientSecret): self
    {
        $credentials = base64_encode(implode(':', [$clientId, $clientSecret]));

        $client = new GuzzleClient([
            'http_errors' => false,
            'headers' => [
                'Authorization' => "Basic {$credentials}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        $response = $client->post(self::$authEndpoint, [
            'form_params' => ['grant_type' => 'client_credentials']
        ]);

        $status = $response->getStatusCode();
        $content = $response->getBody()->getContents();
        var_dump($status, $content);
        exit;

        if ($response->getStatusCode() !== 200) {
            throw new UnableToAuthenticateException('Unable to authenticate through the client credentials flow.');
        }

        return new self(Arr::get(
            json_decode($response->getBody()->getContents(), true),
            'access_token'
        ));
    }
}
