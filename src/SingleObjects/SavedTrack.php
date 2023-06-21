<?php

namespace Spotify\SingleObjects;

class SavedTrack extends ApiResource
{
    protected array $singleObjects = [
        'track' => Track::class,
    ];
}
