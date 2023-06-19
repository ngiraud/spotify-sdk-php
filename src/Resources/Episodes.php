<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Album;
use Spotify\SingleObjects\Episode;
use Spotify\SingleObjects\SavedEpisode;
use Spotify\Support\PaginatedResults;

class Episodes extends SpotifyResource
{
    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-an-episode
     *
     * @param  string|array<string>  $id
     * @return Episode|PaginatedResults<Episode>
     */
    public function find(string|array $id, array $payload = []): Episode|PaginatedResults
    {
        if (is_array($id)) {
            return $this->findMultiple($id, $payload);
        }

        return new Episode($this->client->get("episodes/{$id}", $payload));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-multiple-episodes
     *
     * @param  array<string>  $ids
     * @return PaginatedResults<Episode>
     */
    public function findMultiple(array $ids, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'episodes',
            mappingClass: Episode::class,
            client: $this->client,
            payload: ['ids' => implode(',', array_filter($ids)), ...$payload],
            itemsKey: 'episodes',
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-saved-episodes
     *
     * @return PaginatedResults<SavedEpisode>
     */
    public function findSaved(array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'me/episodes',
            mappingClass: SavedEpisode::class,
            client: $this->client,
            payload: $payload,
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/save-episodes-user
     *
     * @param  string|array<string>  $ids
     */
    public function save(string|array $ids): mixed
    {
        return $this->client->put(sprintf('me/episodes?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/remove-episodes-user
     *
     * @param  string|array<string>  $ids
     */
    public function deleteSaved(string|array $ids): mixed
    {
        return $this->client->delete(sprintf('me/episodes?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/check-users-saved-episodes
     *
     * @param  string|array<string>  $ids
     */
    public function checkSaved(string|array $ids): mixed
    {
        return $this->client->get('me/episodes/contains', ['ids' => implode(',', (array) $ids)]);
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
