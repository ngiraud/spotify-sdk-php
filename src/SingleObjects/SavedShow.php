<?php

namespace Spotify\SingleObjects;

class SavedShow extends ApiResource
{
    protected array $singleObjects = [
        'show' => Show::class,
    ];
}
