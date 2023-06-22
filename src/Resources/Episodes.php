<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Episode;
use Spotify\SingleObjects\SavedEpisode;
use Spotify\Support\PaginatedResults;

class Episodes extends SpotifyResource
{
    /**
     * Get Spotify catalog information for a single or multiple episodes identified by their unique Spotify IDs.
     *
     * @scope user-read-playback-position
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-an-episode
     *
     * @param  string|array<string>  $id
     * @param  array<string, string>  $payload
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
     * Get Spotify catalog information for several episodes based on their Spotify IDs.
     *
     * @scope user-read-playback-position
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-multiple-episodes
     *
     * @param  array<string>  $ids
     * @param  array<string, string>  $payload
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
     * Get a list of the episodes saved in the current Spotify user's library.
     * This API endpoint is in beta and could change without warning. Please share any feedback that you have, or issues that you discover, in our developer community forum.
     *
     * @scope user-read-playback-position, user-library-read
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-saved-episodes
     *
     * @param  array<string, string|integer>  $payload
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
     * Save one or more episodes to the current user's library.
     * This API endpoint is in beta and could change without warning. Please share any feedback that you have, or issues that you discover, in our developer community forum.
     *
     * @scope user-library-modify
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/save-episodes-user
     *
     * @param  string|array<string>  $ids
     */
    public function save(string|array $ids): mixed
    {
        return $this->client->put(sprintf('me/episodes?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * Remove one or more episodes from the current user's library.
     * This API endpoint is in beta and could change without warning. Please share any feedback that you have, or issues that you discover, in our developer community forum.
     *
     * @scope user-library-modify
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/remove-episodes-user
     *
     * @param  string|array<string>  $ids
     */
    public function deleteSaved(string|array $ids): mixed
    {
        return $this->client->delete(sprintf('me/episodes?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * Check if one or more episodes is already saved in the current Spotify user's 'Your Episodes' library.
     * This API endpoint is in beta and could change without warning. Please share any feedback that you have, or issues that you discover, in our developer community forum.
     *
     * @scope user-library-read
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/check-users-saved-episodes
     *
     * @param  string|array<string>  $ids
     */
    public function checkSaved(string|array $ids): mixed
    {
        return $this->client->get('me/episodes/contains', ['ids' => implode(',', (array) $ids)]);
    }
}
