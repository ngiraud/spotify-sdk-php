<?php

namespace Spotify\Resources;

use Spotify\Helpers\Arr;

class Genres extends SpotifyResource
{
    /**
     * Retrieve a list of available genres seed parameter values for recommendations.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-recommendation-genres
     *
     * @return array<string>
     */
    public function seeds(): array
    {
        return Arr::get(
            (array) $this->client->get('recommendations/available-genre-seeds'),
            'genres',
            []
        );
    }
}
