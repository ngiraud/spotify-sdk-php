<?php

namespace Spotify\SingleObjects;

class SavedTrack extends ApiResource
{
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->track = new Track((array) $this->track);
    }
}
