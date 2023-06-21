<?php

namespace Spotify\SingleObjects;

use Spotify\Helpers\Arr;

class Player extends ApiResource
{
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        if (property_exists($this, 'item') && ! is_null($this->item)) {
            $this->item = match (Arr::exists($this->item, 'album')) {
                true => new Track($this->item),
                false => new Episode($this->item),
            };
        }
    }
}
