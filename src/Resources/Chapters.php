<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Chapter;
use Spotify\Support\PaginatedResults;

class Chapters extends SpotifyResource
{
    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-a-chapter
     *
     * @param  string|array<string>  $id
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
     * @see https://developer.spotify.com/documentation/web-api/reference/get-several-chapters
     *
     * @param  array<string>  $ids
     * @return PaginatedResults<Chapter>
     */
    public function findMultiple(array $ids, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'chapters',
            mappingClass: Chapter::class,
            client: $this->client,
            payload: ['ids' => implode(',', array_filter($ids)), ...$payload],
            itemsKey: 'chapters',
        );
    }
}
