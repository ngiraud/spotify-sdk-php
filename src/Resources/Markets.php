<?php

namespace Spotify\Resources;

use Spotify\Helpers\Arr;

class Markets extends SpotifyResource
{
    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-available-markets
     */
    public function all(): array
    {
        return Arr::get(
            (array) $this->client->get('markets'),
            'markets',
            []
        );
    }
}
