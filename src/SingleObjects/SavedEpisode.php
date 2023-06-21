<?php

namespace Spotify\SingleObjects;

class SavedEpisode extends ApiResource
{
    protected array $singleObjects = [
        'episode' => Episode::class,
    ];
}
