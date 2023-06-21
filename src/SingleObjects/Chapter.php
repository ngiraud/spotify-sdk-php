<?php

namespace Spotify\SingleObjects;

class Chapter extends ApiResource
{
    protected array $singleObjectLists = [
        'images' => Image::class,
    ];

    protected array $singleObjects = [
        'audiobook' => Audiobook::class,
    ];
}
