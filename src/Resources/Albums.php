<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Album;
use Spotify\SingleObjects\SavedAlbum;
use Spotify\SingleObjects\Track;
use Spotify\Support\PaginatedResults;

class Albums extends SpotifyResource
{
    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-an-album
     *
     * @param  string|array<string>  $id
     * @return Album|PaginatedResults<Album>
     */
    public function find(string|array $id, array $payload = []): Album|PaginatedResults
    {
        if (is_array($id)) {
            return $this->findMultiple($id, $payload);
        }

        return new Album($this->client->get("albums/{$id}", $payload));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-multiple-albums
     *
     * @param  array<string>  $ids
     * @return PaginatedResults<Album>
     */
    public function findMultiple(array $ids, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'albums',
            mappingClass: Album::class,
            client: $this->client,
            payload: ['ids' => implode(',', array_filter($ids)), ...$payload],
            itemsKey: 'albums',
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-an-albums-tracks
     */
    public function tracks(string $id, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: "albums/{$id}/tracks",
            mappingClass: Track::class,
            client: $this->client,
            payload: $payload
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-saved-albums
     *
     * @return PaginatedResults<SavedAlbum>
     */
    public function findSaved(array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'me/albums',
            mappingClass: SavedAlbum::class,
            client: $this->client,
            payload: $payload,
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/save-albums-user
     *
     * @param  string|array<string>  $ids
     */
    public function save(string|array $ids): mixed
    {
        return $this->client->put(sprintf('me/albums?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/remove-albums-user
     *
     * @param  string|array<string>  $ids
     */
    public function deleteSaved(string|array $ids): mixed
    {
        return $this->client->delete(sprintf('me/albums?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * IDs passed in the body seems not to be saved, even with the "Try it" from the docs.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/check-users-saved-albums
     *
     * @param  string|array<string>  $ids
     */
    public function checkSaved(string|array $ids): mixed
    {
        return $this->client->get('me/albums/contains', ['ids' => implode(',', (array) $ids)]);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-saved-albums
     *
     * @return PaginatedResults<Album>
     */
    public function newReleases(array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'browse/new-releases',
            mappingClass: Album::class,
            client: $this->client,
            payload: $payload,
            entryKey: 'albums'
        );
    }
}
