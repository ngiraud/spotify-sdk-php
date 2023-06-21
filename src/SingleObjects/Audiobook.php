<?php

namespace Spotify\SingleObjects;

class Audiobook extends ApiResource
{
    protected array $singleObjectLists = [
        'authors' => Author::class,
        'copyrights' => Copyright::class,
        'images' => Image::class,
        'narrators' => Narrator::class,
    ];

    protected array $singleObjects = [
        'album' => Album::class,
    ];

    protected array $paginatedResults = [
        'chapters' => ['mappingClass' => Chapter::class, 'entryKey' => 'chapters'],
    ];
}
