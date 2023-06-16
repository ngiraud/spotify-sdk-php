<?php

namespace Spotify\Concerns;

use Spotify\Resources\Album;
use Spotify\Resources\Artist;
use Spotify\Support\PaginatedResults;

trait HasArtists
{
    /**
     * Doc: https://developer.spotify.com/documentation/web-api/reference/get-an-artist
     */
    public function artist(string $id): Artist
    {
        return new Artist(
            $this->get("artists/{$id}")
        );
    }

    /**
     * Doc: https://developer.spotify.com/documentation/web-api/reference/get-multiple-artists
     *
     * @param  array<string>  $ids
     * @return array<Artist>
     */
    public function artists(array $ids): array
    {
        $results = $this->get('artists', ['ids' => implode(',', array_filter($ids))]);

        if (empty($results['artists'])) {
            return [];
        }

        return array_values(array_map(
            fn ($artist) => new Artist($artist),
            $results['artists']
        ));
    }

    /**
     * Doc: https://developer.spotify.com/documentation/web-api/reference/get-multiple-artists
     */
    public function artistAlbums(string $id, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: "artists/{$id}/albums",
            mappingClass: Album::class,
            client: $this,
            payload: $payload
        );
    }
}
