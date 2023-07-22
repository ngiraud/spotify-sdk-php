<?php

namespace Spotify\Resources;

use Spotify\Factory;

abstract class SpotifyResource
{
    public function __construct(protected Factory $client)
    {
    }
}
