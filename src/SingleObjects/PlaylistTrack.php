<?php

namespace Spotify\SingleObjects;

use Spotify\Helpers\Arr;

class PlaylistTrack extends ApiResource
{
    public string $addedAt;

    /**
     * @var array<string,string|array<string,string|int>>
     */
    public array $addedBy;

    public bool $isLocal;

    public Track|Episode $track;

    protected function beforeFill(): void
    {
        if (!empty($type = Arr::get($this->attributes, 'track.type'))) {
            $this->singleObjects['track'] = match ($type) {
                'episode' => Episode::class,
                default => Track::class,
            };
        }
    }
}
