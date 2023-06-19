<?php

namespace Spotify;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use Spotify\Resources\Albums;
use Spotify\Resources\Artists;
use Spotify\Resources\Audiobooks;
use Spotify\Resources\Categories;
use Spotify\Resources\Episodes;
use Spotify\Resources\Genres;
use Spotify\Resources\Markets;
use Spotify\Resources\Playlists;
use Spotify\Resources\Shows;
use Spotify\Resources\Tracks;
use Spotify\Resources\Users;
use Spotify\SingleObjects\Search;

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

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/search
     */
    public function search(string $q, string|array $type, array $payload = []): Search
    {
        return new Search(
            $this->get('search', ['q' => $q, 'type' => implode(',', (array) $type), ...$payload])
        );
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

    public function genres(): Genres
    {
        return new Genres($this);
    }

    public function markets(): Markets
    {
        return new Markets($this);
    }

    public function audiobooks(): Audiobooks
    {
        return new Audiobooks($this);
    }

    public function episodes(): Episodes
    {
        return new Episodes($this);
    }

    public function shows(): Shows
    {
        return new Shows($this);
    }

    public function users(): Users
    {
        return new Users($this);
    }

    public function playlists(): Playlists
    {
        return new Playlists($this);
    }
}
