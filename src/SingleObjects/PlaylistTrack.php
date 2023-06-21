<?php

namespace Spotify\SingleObjects;

class PlaylistTrack extends ApiResource
{
    protected array $singleObjects = [
        'track' => Track::class,
    ];
}
