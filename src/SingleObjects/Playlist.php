<?php

namespace Spotify\SingleObjects;

class Playlist extends ApiResource
{
    protected array $singleObjectLists = [
        'images' => Image::class,
    ];

    protected array $singleObjects = [
        'owner' => User::class,
    ];

    protected array $paginatedResults = [
        'tracks' => ['mappingClass' => PlaylistTrack::class, 'entryKey' => 'tracks'],
    ];
}
