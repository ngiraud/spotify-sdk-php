<?php

namespace Spotify\SingleObjects;

class Episode extends ApiResource
{
    protected array $singleObjectLists = [
        'images' => Image::class,
    ];

    protected array $singleObjects = [
        'show' => Show::class,
    ];
}
