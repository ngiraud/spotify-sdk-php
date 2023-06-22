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
use Spotify\Resources\Player;
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
        protected string $accessToken,
        protected ?ClientInterface $client = null
    ) {
        $this->client ??= new GuzzleClient([
            'http_errors' => false,
            'base_uri' => $this->endpoint.'/',
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

    public function endpoint(): string
    {
        return $this->endpoint;
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
}
