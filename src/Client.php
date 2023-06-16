<?php

namespace Spotify;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use Spotify\Concerns;

class Client
{
    use MakesHttpRequests;
    use Concerns\HasSearch;
    use Concerns\HasArtists;

    protected string $endpoint = 'https://api.spotify.com/v1';

    public function __construct(
        protected string $apiKey,
        protected ?ClientInterface $client = null
    ) {
        $this->client ??= new GuzzleClient([
            'http_errors' => false,
            'base_uri' => $this->endpoint.'/',
            'headers' => [
                'Authorization' => "Bearer {$this->apiKey}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function apiToken(): string
    {
        return $this->apiKey;
    }

    public function endpoint(): string
    {
        return $this->endpoint;
    }

    public function client(): ?ClientInterface
    {
        return $this->client;
    }
}
