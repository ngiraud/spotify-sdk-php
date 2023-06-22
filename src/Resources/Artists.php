<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Album;
use Spotify\SingleObjects\Artist;
use Spotify\SingleObjects\Track;
use Spotify\Support\PaginatedResults;

class Artists extends SpotifyResource
{
    /**
     * Get Spotify catalog information for a single or multiple artists identified by their unique Spotify IDs.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-an-artist
     *
     * @param  string|array<string>  $id
     *
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
     * Get Spotify catalog information for several artists based on their Spotify IDs.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-multiple-artists
     *
     * @param  array<string>  $ids
     *
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
     * Get Spotify catalog information about an artist's albums.
     *
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
     * Get Spotify catalog information about an artist's top tracks by country.
     *
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
     * Get Spotify catalog information about artists similar to a given artist.
     * Similarity is based on analysis of the Spotify community's listening history.
     *
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
