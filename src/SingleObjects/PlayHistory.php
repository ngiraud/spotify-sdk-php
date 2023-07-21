<?php

namespace Spotify\SingleObjects;

class PlayHistory extends ApiResource
{
    protected array $singleObjects = [
        'track' => Track::class,
    ];

    public Track $track;

    public string $playedAt;

    /**
     * @var null|array<string,string|array<string,string>>
     */
    public ?array $context = null;
}
