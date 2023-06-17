<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Album;
use Spotify\SingleObjects\Artist;
use Spotify\SingleObjects\Track;
use Spotify\Support\PaginatedResults;

class Artists extends SpotifyResource
{
    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-an-artist
     *
     * @param  string|array<string>  $id
     * @return Artist|PaginatedResults<Artist>
     */
    public function find(string|array $id): Artist|PaginatedResults
    {
        if (is_array($id)) {
            return $this->findMultiple($id);
        }

        return new Artist($this->client->get("artists/{$id}"));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-multiple-artists
     *
     * @param  array<string>  $ids
     * @return PaginatedResults<Artist>
     */
    public function findMultiple(array $ids): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'artists',
            mappingClass: Artist::class,
            client: $this->client,
            payload: ['ids' => implode(',', array_filter($ids))],
            itemsKey: 'artists',
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-an-artists-albums
     */
    public function albums(string $id, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: "artists/{$id}/albums",
            mappingClass: Album::class,
            client: $this->client,
            payload: $payload
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-an-artists-top-tracks
     */
    public function topTracks(string $id, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: "artists/{$id}/top-tracks",
            mappingClass: Track::class,
            client: $this->client,
            payload: $payload,
            itemsKey: 'tracks'
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-an-artists-related-artists
     */
    public function relatedArtists(string $id): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: "artists/{$id}/related-artists",
            mappingClass: Artist::class,
            client: $this->client,
            itemsKey: 'artists'
        );
    }
}
