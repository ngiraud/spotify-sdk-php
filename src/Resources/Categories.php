<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Category;
use Spotify\Support\PaginatedResults;

class Categories extends SpotifyResource
{
    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-a-category
     */
    public function find(string $id, array $payload = []): Category
    {
        return new Category($this->client->get("browse/categories/{$id}", $payload));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-categories
     *
     * @param  array  $payload
     *
     * @return PaginatedResults<Category>
     */
    public function browse(array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'browse/categories',
            mappingClass: Category::class,
            client: $this->client,
            payload: $payload,
            entryKey: 'categories',
        );
    }
}
