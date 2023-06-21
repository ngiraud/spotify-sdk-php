<?php

namespace Spotify\SingleObjects;

class Track extends ApiResource
{
    protected array $singleObjectLists = [
        'artists' => Artist::class,
    ];

    protected array $singleObjects = [
        'album' => Album::class,
    ];
}
