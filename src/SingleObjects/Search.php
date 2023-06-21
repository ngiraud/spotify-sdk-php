<?php

namespace Spotify\SingleObjects;

use Spotify\Support\PaginatedResults;

class Search extends ApiResource
{
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
