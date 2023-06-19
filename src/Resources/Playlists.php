<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Playlist;
use Spotify\SingleObjects\Track;
use Spotify\Support\PaginatedResults;

class Playlists extends SpotifyResource
{
    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-playlist
     */
    public function find(string $id, array $payload = []): Playlist
    {
        return new Playlist($this->client->get("playlists/{$id}", $payload));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-a-list-of-current-users-playlists
     */
    public function forCurrentUser(array $payload = []): PaginatedResults
    {
        return $this->forUser(payload: $payload);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-list-users-playlists
     */
    public function forUser(?string $id = null, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: is_null($id) ? 'me/playlists' : "users/{$id}/playlists",
            mappingClass: Playlist::class,
            client: $this->client,
            payload: $payload
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/create-playlist
     */
    public function create(string $id, array $payload): Playlist
    {
        return new Playlist($this->client->post("users/{$id}/playlists", $payload));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/change-playlist-details
     */
    public function update(string $id, array $payload): mixed
    {
        return $this->client->put("playlists/{$id}", $payload);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-playlists-tracks
     */
    public function tracks(string $id, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: "playlists/{$id}/tracks",
            mappingClass: Track::class,
            client: $this->client,
            payload: $payload
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/reorder-or-replace-playlists-tracks
     */
    public function reorderTracks(string $id, array $payload): mixed
    {
        return $this->client->put("playlists/{$id}/tracks", $payload);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/reorder-or-replace-playlists-tracks
     */
    public function replaceTracks(string $id, string|array $uris = []): mixed
    {
        return $this->client->put(
            sprintf("playlists/{$id}/tracks?uris=%s", implode(',', (array) $uris)),
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/add-tracks-to-playlist
     */
    public function addTracks(string $id, int $position, string|array $uris): mixed
    {
        return $this->client->post(
            "playlists/{$id}/tracks",
            ['position' => $position, 'uris' => (array) $uris],
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/remove-tracks-playlist
     */
    public function deleteTracks(string $id, string|array $uris, array $payload = []): mixed
    {
        return $this->client->delete(
            "playlists/{$id}/tracks",
            ['tracks' => array_map(fn ($uri) => ['uri' => $uri], (array) $uris), ...$payload],
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-featured-playlists
     */
    public function featured(array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'browse/featured-playlists',
            mappingClass: Playlist::class,
            client: $this->client,
            payload: $payload,
            entryKey: 'playlists'
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-a-categories-playlists
     */
    public function forCategory(string $id, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: "browse/categories/{$id}/playlists",
            mappingClass: Playlist::class,
            client: $this->client,
            payload: $payload,
            entryKey: 'playlists'
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-playlist-cover
     */
    public function coverImage(string $id): array
    {
        return $this->client->get("playlists/{$id}/images");
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/upload-custom-playlist-cover
     */
    public function addCoverImage(string $id, string $base64Image): mixed
    {
        return $this->client->request('PUT', "playlists/{$id}/images", $base64Image, 'body');
    }
}
