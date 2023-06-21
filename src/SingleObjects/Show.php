<?php

namespace Spotify\SingleObjects;

class Show extends ApiResource
{
    protected array $singleObjectLists = [
        'copyrights' => Copyright::class,
        'images' => Image::class,
    ];

    protected array $paginatedResults = [
        'episodes' => Episode::class,
    ];
}
