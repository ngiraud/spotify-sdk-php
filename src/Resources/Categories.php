<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Category;
use Spotify\Support\PaginatedResults;

class Categories extends SpotifyResource
{
    /**
     * Get a single category used to tag items in Spotify (on, for example, the Spotify player’s “Browse” tab).
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-a-category
     *
     * @param  array<string, string>  $payload
     */
    public function find(string $id, array $payload = []): Category
    {
        return new Category($this->client->get("browse/categories/{$id}", $payload));
    }

    /**
     * Get a list of categories used to tag items in Spotify (on, for example, the Spotify player’s “Browse” tab).
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-categories
     *
     * @param  array<string, string|integer>  $payload
     * @return PaginatedResults<Category>
     */
    public function browse(array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'browse/categories',
            mappingClass: Category::class,
            factory: $this->client,
            payload: $payload,
            entryKey: 'categories',
        );
    }
}
