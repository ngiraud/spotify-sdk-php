<?php

namespace Spotify\SingleObjects;

class SavedAudiobook extends ApiResource
{
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->audiobook = new Audiobook((array) $this->audiobook);
    }
}
