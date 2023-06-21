<?php

namespace Spotify\SingleObjects;

class Album extends ApiResource
{
    protected array $singleObjectLists = [
        'artists' => Artist::class,
        'copyrights' => Copyright::class,
        'images' => Image::class,
    ];

    protected array $paginatedResults = [
        'tracks' => ['mappingClass' => Track::class, 'entryKey' => 'tracks'],
    ];
}
