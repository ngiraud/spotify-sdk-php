<?php

namespace Spotify\SingleObjects;

use Spotify\Helpers\Arr;

class PlaybackState extends ApiResource
{
    public Device $device;

    public string $repeatState;

    public bool $shuffleState;

    /**
     * @var null|array<string,string|array<string,string>>
     */
    public ?array $context = null;

    public int $timestamp;

    public ?int $progressMs = null;

    public bool $isPlaying;

    public Track|Episode|null $item = null;

    public string $currentlyPlayingType;

    /**
     * @var array<string,bool>
     */
    public array $actions;

    protected function beforeFill(): void
    {
        if (!empty($type = Arr::get($this->attributes, 'currently_playing_type'))) {
            $this->singleObjects['item'] = match ($type) {
                'episode' => Episode::class,
                default => Track::class,
            };
        }
    }
}
