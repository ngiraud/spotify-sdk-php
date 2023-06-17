<?php

namespace Spotify\Resources;

use Spotify\Helpers\Arr;

class Genres extends SpotifyResource
{
    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-recommendation-genres
     */
    public function seeds(): array
    {
        return Arr::get(
            (array) $this->client->get('recommendations/available-genre-seeds'),
            'genres'
        );
    }
}
