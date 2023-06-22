<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Episode;
use Spotify\SingleObjects\SavedShow;
use Spotify\SingleObjects\Show;
use Spotify\Support\PaginatedResults;

class Shows extends SpotifyResource
{
    /**
     * Get Spotify catalog information for a single or multiple shows identified by their unique Spotify IDs.
     *
     * @scope user-read-playback-position
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-a-show
     *
     * @param  string|array<string>  $id
     * @param  array<string, string>  $payload
     * @return Show|PaginatedResults<Show>
     */
    public function find(string|array $id, array $payload = []): Show|PaginatedResults
    {
        if (is_array($id)) {
            return $this->findMultiple($id, $payload);
        }

        return new Show($this->client->get("shows/{$id}", $payload));
    }

    /**
     * Get Spotify catalog information for several shows based on their Spotify IDs.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-multiple-shows
     *
     * @param  array<string>  $ids
     * @param  array<string, string>  $payload
     * @return PaginatedResults<Show>
     */
    public function findMultiple(array $ids, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'shows',
            mappingClass: Show::class,
            client: $this->client,
            payload: ['ids' => implode(',', array_filter($ids)), ...$payload],
            itemsKey: 'shows',
        );
    }

    /**
     * Get Spotify catalog information about an show’s episodes. Optional parameters can be used to limit the number of episodes returned.
     *
     * @scope user-read-playback-position
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-a-shows-episodes
     *
     * @param  array<string, string|integer>  $payload
     */
    public function episodes(string $id, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: "shows/{$id}/episodes",
            mappingClass: Episode::class,
            client: $this->client,
            payload: $payload
        );
    }

    /**
     * Get a list of shows saved in the current Spotify user's library. Optional parameters can be used to limit the number of shows returned.
     *
     * @scope user-library-read
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-saved-shows
     *
     * @param  array<string, integer>  $payload
     * @return PaginatedResults<SavedShow>
     */
    public function findSaved(array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'me/shows',
            mappingClass: SavedShow::class,
            client: $this->client,
            payload: $payload,
        );
    }

    /**
     * Save one or more shows to current Spotify user's library.
     *
     * @scope user-library-modify
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/save-shows-user
     *
     * @param  string|array<string>  $ids
     */
    public function save(string|array $ids): mixed
    {
        return $this->client->put(sprintf('me/shows?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * Delete one or more shows from current Spotify user's library.
     *
     * @scope user-library-modify
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/save-shows-user
     *
     * @param  string|array<string>  $ids
     */
    public function deleteSaved(string|array $ids): mixed
    {
        return $this->client->delete(sprintf('me/shows?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * Check if one or more shows is already saved in the current Spotify user's library.
     *
     * @scope user-library-read
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/check-users-saved-shows
     *
     * @param  string|array<string>  $ids
     */
    public function checkSaved(string|array $ids): mixed
    {
        return $this->client->get('me/shows/contains', ['ids' => implode(',', (array) $ids)]);
    }
}
