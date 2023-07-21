<?php

namespace Spotify\SingleObjects;

class SavedAlbum extends ApiResource
{
    protected array $singleObjects = [
        'album' => Album::class,
    ];

    public string $addedAt;

    public Album $album;
}
