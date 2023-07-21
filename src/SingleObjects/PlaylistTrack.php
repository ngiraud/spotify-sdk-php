<?php

namespace Spotify\SingleObjects;

class PlaylistTrack extends ApiResource
{
    protected array $singleObjects = [
        // @todo track can be a Track or an Episode
        'track' => Track::class,
    ];

    public string $addedAt;

    /**
     * @var array<string,string|array<string,string|int>>
     */
    public array $addedBy;

    public bool $isLocal;

    public Track|Episode $track;
}
