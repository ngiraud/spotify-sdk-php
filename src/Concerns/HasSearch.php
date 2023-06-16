<?php

namespace Spotify\Concerns;

use Spotify\Resources\Search;

trait HasSearch
{
    /**
     * Doc: https://developer.spotify.com/documentation/web-api/reference/search
     */
    public function search(string $q, array|string $types, array $payload = []): Search
    {
        $results = $this->get('search', array_merge($payload, [
            'q' => $q,
            'type' => (array) $types,
        ]));

        return new Search(
            $this->get('search', array_merge($payload, [
                'q' => $q,
                'type' => (array) $types,
            ]))
        );
    }
}
