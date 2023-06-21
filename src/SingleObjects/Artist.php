<?php

namespace Spotify\SingleObjects;

class Artist extends ApiResource
{
    protected array $singleObjectLists = [
        'images' => Image::class,
    ];
}
