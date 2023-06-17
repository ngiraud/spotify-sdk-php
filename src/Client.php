<?php

namespace Spotify;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use Spotify\Resources\Albums;
use Spotify\Resources\Artists;
use Spotify\Resources\Categories;
use Spotify\Resources\Tracks;

class Client
{
    use MakesHttpRequests;

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

    public function artists(): Artists
    {
        return new Artists($this);
    }

    public function albums(): Albums
    {
        return new Albums($this);
    }

    public function tracks(): Tracks
    {
        return new Tracks($this);
    }

    public function categories(): Categories
    {
        return new Categories($this);
    }
}
