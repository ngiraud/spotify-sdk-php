<?php

namespace Spotify\SingleObjects;

class Album extends ApiResource
{
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->mapArtists();
    }

    protected function mapArtists(): void
    {
        if (! is_array($this->artists)) {
            return;
        }

        $this->artists = array_map(
            fn (array $attributes) => new Artist($attributes),
            $this->artists
        );
    }
}
