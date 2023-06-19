<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Episode;
use Spotify\SingleObjects\SavedShow;
use Spotify\SingleObjects\Show;
use Spotify\Support\PaginatedResults;

class Shows extends SpotifyResource
{
    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-a-show
     *
     * @param  string|array<string>  $id
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
     * @see https://developer.spotify.com/documentation/web-api/reference/get-multiple-shows
     *
     * @param  array<string>  $ids
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
     * @see https://developer.spotify.com/documentation/web-api/reference/get-a-shows-episodes
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
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-saved-shows
     *
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
     * @see https://developer.spotify.com/documentation/web-api/reference/save-shows-user
     *
     * @param  string|array<string>  $ids
     */
    public function save(string|array $ids): mixed
    {
        return $this->client->put(sprintf('me/shows?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/save-shows-user
     *
     * @param  string|array<string>  $ids
     */
    public function deleteSaved(string|array $ids): mixed
    {
        return $this->client->delete(sprintf('me/shows?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/check-users-saved-shows
     *
     * @param  string|array<string>  $ids
     */
    public function checkSaved(string|array $ids): mixed
    {
        return $this->client->get('me/shows/contains', ['ids' => implode(',', (array) $ids)]);
    }
}
