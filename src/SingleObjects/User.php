<?php

namespace Spotify\SingleObjects;

class User extends ApiResource
{
    protected array $singleObjectLists = [
        'images' => Image::class,
    ];
}
