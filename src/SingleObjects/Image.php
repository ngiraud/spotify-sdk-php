<?php

namespace Spotify\SingleObjects;

class Image extends ApiResource
{
    public string $url;

    public ?int $height = null;

    public ?int $width = null;
}
