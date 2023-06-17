<?php

namespace Spotify\SingleObjects;

class SavedAlbum extends ApiResource
{
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->album = new Album((array) $this->album);
    }
}
