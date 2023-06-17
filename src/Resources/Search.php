<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Search as SearchSingleObject;

class Search extends SpotifyResource
{
    /**
     * @link https://developer.spotify.com/documentation/web-api/reference/search
     */
    public function search(string $q, array|string $types, array $payload = []): SearchSingleObject
    {
        return new SearchSingleObject(
            $this->client->get('search', array_merge($payload, [
                'q' => $q,
                'type' => (array) $types,
            ]))
        );
    }
}
