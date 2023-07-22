<?php

namespace Spotify\SingleObjects;

use Spotify\Support\PaginatedResults;

class Search extends ApiResource
{
    const TYPE_ALBUM = 'album';
    const TYPE_ARTIST = 'artist';
    const TYPE_PLAYLIST = 'playlist';
    const TYPE_TRACK = 'track';
    const TYPE_SHOW = 'show';
    const TYPE_EPISODE = 'episode';
    const TYPE_AUDIOBOOK = 'audiobook';

    /**
     * @var array<string,mixed>
     */
    protected array $albums;

    /**
     * @var array<string,mixed>
     */
    protected array $artists;

    /**
     * @var array<string,mixed>
     */
    protected array $playlists;

    /**
     * @var array<string,mixed>
     */
    protected array $tracks;

    /**
     * @var array<string,mixed>
     */
    protected array $shows;

    /**
     * @var array<string,mixed>
     */
    protected array $episodes;

    /**
     * @var array<string,mixed>
     */
    protected array $audiobooks;

    public function audiobooks(): PaginatedResults
    {
        return new PaginatedResults(
            response: $this->attributes,
            mappingClass: Audiobook::class,
            entryKey: 'audiobooks'
        );
    }

    public function albums(): PaginatedResults
    {
        return new PaginatedResults(
            response: $this->attributes,
            mappingClass: Album::class,
            entryKey: 'albums'
        );
    }

    public function artists(): PaginatedResults
    {
        return new PaginatedResults(
            response: $this->attributes,
            mappingClass: Artist::class,
            entryKey: 'artists'
        );
    }

    public function episodes(): PaginatedResults
    {
        return new PaginatedResults(
            response: $this->attributes,
            mappingClass: Episode::class,
            entryKey: 'episodes'
        );
    }

    public function playlists(): PaginatedResults
    {
        return new PaginatedResults(
            response: $this->attributes,
            mappingClass: Playlist::class,
            entryKey: 'playlists'
        );
    }

    public function shows(): PaginatedResults
    {
        return new PaginatedResults(
            response: $this->attributes,
            mappingClass: Show::class,
            entryKey: 'shows'
        );
    }

    public function tracks(): PaginatedResults
    {
        return new PaginatedResults(
            response: $this->attributes,
            mappingClass: Track::class,
            entryKey: 'tracks'
        );
    }
}
