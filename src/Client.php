<?php

namespace Spotify;

use Spotify\Resources\Albums;
use Spotify\Resources\Artists;
use Spotify\Resources\Audiobooks;
use Spotify\Resources\Categories;
use Spotify\Resources\Chapters;
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
    public function __construct(protected Factory $factory)
    {
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
            (array) $this->factory->get('search', ['q' => $q, 'type' => implode(',', (array) $type), ...$payload])
        );
    }

    /**
     * Manages Albums endpoints
     */
    public function albums(): Albums
    {
        return new Albums($this->factory);
    }

    /**
     * Manages Artists endpoints
     */
    public function artists(): Artists
    {
        return new Artists($this->factory);
    }

    /**
     * Manages Audiobooks endpoints
     */
    public function audiobooks(): Audiobooks
    {
        return new Audiobooks($this->factory);
    }

    /**
     * Manages Categories endpoints
     */
    public function categories(): Categories
    {
        return new Categories($this->factory);
    }

    /**
     * Manages Chapters endpoints
     */
    public function chapters(): Chapters
    {
        return new Chapters($this->factory);
    }

    /**
     * Manages Episodes endpoints
     */
    public function episodes(): Episodes
    {
        return new Episodes($this->factory);
    }

    /**
     * Manages Genres endpoints
     */
    public function genres(): Genres
    {
        return new Genres($this->factory);
    }

    /**
     * Manages Markets endpoints
     */
    public function markets(): Markets
    {
        return new Markets($this->factory);
    }

    /**
     * Manages Player endpoints
     */
    public function player(): Player
    {
        return new Player($this->factory);
    }

    /**
     * Manages Playlists endpoints
     */
    public function playlists(): Playlists
    {
        return new Playlists($this->factory);
    }

    /**
     * Manages Shows endpoints
     */
    public function shows(): Shows
    {
        return new Shows($this->factory);
    }

    /**
     * Manages Tracks endpoints
     */
    public function tracks(): Tracks
    {
        return new Tracks($this->factory);
    }

    /**
     * Manages Users endpoints
     */
    public function users(): Users
    {
        return new Users($this->factory);
    }
}
