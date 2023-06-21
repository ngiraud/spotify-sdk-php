<?php

namespace Spotify\SingleObjects;

class PlayHistory extends ApiResource
{
    protected array $singleObjects = [
        'track' => Track::class,
    ];
}
