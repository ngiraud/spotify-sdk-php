<?php

namespace Spotify\SingleObjects;

use Spotify\Helpers\Arr;

class UserQueue extends ApiResource
{
    public Track|Episode|null $currentlyPlaying = null;

    /**
     * @var array<Track|Episode>|null
     */
    public ?array $queue = null;

    protected function beforeFill(): void
    {
        if (! empty($type = Arr::get($this->attributes, 'currently_playing.type'))) {
            $this->singleObjects['currentlyPlaying'] = match ($type) {
                'episode' => Episode::class,
                default => Track::class,
            };
        }
    }

    protected function afterFill(): void
    {
        if (! empty($this->queue)) {
            foreach ($this->queue as $key => $item) {
                $mappingClass = match (Arr::get($item->toArray(), 'type')) {
                    'track' => Track::class,
                    'episode' => Episode::class,
                    default => null,
                };

                if (! is_null($mappingClass)) {
                    $this->queue[$key] = new $mappingClass($item->toArray());
                }
            }
        }
    }
}
