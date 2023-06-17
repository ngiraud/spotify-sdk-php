<?php

namespace Spotify\Resources;

use Spotify\Client;

abstract class SpotifyResource
{
    public function __construct(protected Client $client)
    {
    }
}
