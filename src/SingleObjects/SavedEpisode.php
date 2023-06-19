<?php

namespace Spotify\SingleObjects;

class SavedEpisode extends ApiResource
{
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->episode = new Episode((array) $this->episode);
    }
}
