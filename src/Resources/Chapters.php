<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Chapter;
use Spotify\Support\PaginatedResults;

class Chapters extends SpotifyResource
{
    /**
     * Get Spotify catalog information for a single or multiple chapters.
     * Note: Chapters are only available for the US, UK, Ireland, New Zealand and Australia markets.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-a-chapter
     *
     * @param  string|array<string>  $id
     * @param  array<string, string>  $payload
     *
     * @return Chapter|PaginatedResults<Chapter>
     */
    public function find(string|array $id, array $payload = []): Chapter|PaginatedResults
    {
        if (is_array($id)) {
            return $this->findMultiple($id, $payload);
        }

        return new Chapter($this->client->get("chapters/{$id}", $payload));
    }

    /**
     * Get Spotify catalog information for several chapters identified by their Spotify IDs.
     * Note: Chapters are only available for the US, UK, Ireland, New Zealand and Australia markets.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-several-chapters
     *
     * @param  array<string>  $ids
     * @param  array<string, string>  $payload
     *
     * @return PaginatedResults<Chapter>
     */
    public function findMultiple(array $ids, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'chapters',
            mappingClass: Chapter::class,
            factory: $this->client,
            payload: ['ids' => implode(',', array_filter($ids)), ...$payload],
            itemsKey: 'chapters',
        );
    }
}
