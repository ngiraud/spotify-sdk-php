<?php

namespace Spotify\SingleObjects;

class SavedShow extends ApiResource
{
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->show = new Show((array) $this->show);
    }
}
