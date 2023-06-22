<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Playlist;
use Spotify\SingleObjects\PlaylistTrack;
use Spotify\Support\PaginatedResults;

class Playlists extends SpotifyResource
{
    /**
     * Get a playlist owned by a Spotify user.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-playlist
     *
     * @param  array<string, string>  $payload
     */
    public function find(string $id, array $payload = []): Playlist
    {
        return new Playlist($this->client->get("playlists/{$id}", $payload));
    }

    /**
     * Get a list of the playlists owned or followed by the current Spotify user.
     *
     * @scope playlist-read-private
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-a-list-of-current-users-playlists
     *
     * @param  array<string, integer>  $payload
     */
    public function forCurrentUser(array $payload = []): PaginatedResults
    {
        return $this->forUser(payload: $payload);
    }

    /**
     * Get a list of the playlists owned or followed by a Spotify user.
     *
     * @scope playlist-read-private, playlist-read-collaborative
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-list-users-playlists
     *
     * @param  array<string, integer>  $payload
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
     * Create a playlist for a Spotify user. (The playlist will be empty until you add tracks.)
     *
     * @scope playlist-modify-public, playlist-modify-private
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/create-playlist
     *
     * @param  array<string, string|boolean>  $payload
     */
    public function create(string $id, array $payload): Playlist
    {
        return new Playlist($this->client->post("users/{$id}/playlists", $payload));
    }

    /**
     * Change a playlist's name and public/private state. (The user must, of course, own the playlist.)
     *
     * @scope playlist-modify-public, playlist-modify-private
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/change-playlist-details
     *
     * @param  array<string, string|boolean>  $payload
     */
    public function update(string $id, array $payload): mixed
    {
        return $this->client->put("playlists/{$id}", $payload);
    }

    /**
     * Get full details of the items of a playlist owned by a Spotify user.
     *
     * @scope playlist-read-private
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-playlists-tracks
     *
     * @param  array<string, string|integer>  $payload
     */
    public function tracks(string $id, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: "playlists/{$id}/tracks",
            mappingClass: PlaylistTrack::class,
            client: $this->client,
            payload: $payload
        );
    }

    /**
     * Either reorder or replace items in a playlist depending on the request's parameters.
     * To reorder items, include range_start, insert_before, range_length and snapshot_id in the request's body.
     * To replace items, include uris as either a query parameter or in the request's body. Replacing items in a playlist will overwrite its existing items.
     * This operation can be used for replacing or clearing items in a playlist.
     * Note: Replace and reorder are mutually exclusive operations which share the same endpoint, but have different parameters. These operations can't be applied together in a single request.
     *
     * @scope playlist-modify-public, playlist-modify-private
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/reorder-or-replace-playlists-tracks
     *
     * @param  array<string, string|integer>  $payload
     */
    public function reorderTracks(string $id, array $payload): mixed
    {
        return $this->client->put("playlists/{$id}/tracks", $payload);
    }

    /**
     * Either reorder or replace items in a playlist depending on the request's parameters.
     * To reorder items, include range_start, insert_before, range_length and snapshot_id in the request's body.
     * To replace items, include uris as either a query parameter or in the request's body. Replacing items in a playlist will overwrite its existing items.
     * This operation can be used for replacing or clearing items in a playlist.
     * Note: Replace and reorder are mutually exclusive operations which share the same endpoint, but have different parameters. These operations can't be applied together in a single request.
     *
     * @scope playlist-modify-public, playlist-modify-private
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/reorder-or-replace-playlists-tracks
     *
     * @param  string|array<string>  $uris
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/reorder-or-replace-playlists-tracks
     */
    public function replaceTracks(string $id, string|array $uris = []): mixed
    {
        return $this->client->put(
            sprintf("playlists/{$id}/tracks?uris=%s", implode(',', (array) $uris)),
        );
    }

    /**
     * Add one or more items to a user's playlist.
     *
     * @scope playlist-modify-public, playlist-modify-private
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/add-tracks-to-playlist
     *
     * @param  string|array<string>  $uris
     */
    public function addTracks(string $id, int $position, string|array $uris): mixed
    {
        return $this->client->post(
            "playlists/{$id}/tracks",
            ['position' => $position, 'uris' => (array) $uris],
        );
    }

    /**
     * Remove one or more items from a user's playlist.
     *
     * @scope playlist-modify-public, playlist-modify-private
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/remove-tracks-playlist
     *
     * @param  string|array<string>  $uris
     * @param  array<string, string>  $payload
     */
    public function deleteTracks(string $id, string|array $uris, array $payload = []): mixed
    {
        return $this->client->delete(
            "playlists/{$id}/tracks",
            ['tracks' => array_map(fn ($uri) => ['uri' => $uri], (array) $uris), ...$payload],
        );
    }

    /**
     * Get a list of Spotify featured playlists (shown, for example, on a Spotify player's 'Browse' tab).
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-featured-playlists
     *
     * @param  array<string, string|integer>  $payload
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
     * Get a list of Spotify playlists tagged with a particular category.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-a-categories-playlists
     *
     * @param  array<string, string|integer>  $payload
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
     * Get the current image associated with a specific playlist.
     *
     * @scope ugc-image-upload,playlist-modify-public, playlist-modify-private
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-playlist-cover
     *
     * @return array<string, string|integer>
     */
    public function coverImage(string $id): array
    {
        return $this->client->get("playlists/{$id}/images");
    }

    /**
     * Replace the image used to represent a specific playlist.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/upload-custom-playlist-cover
     */
    public function addCoverImage(string $id, string $base64Image): mixed
    {
        return $this->client->request('PUT', "playlists/{$id}/images", $base64Image, 'body');
    }
}
