<?php

namespace Spotify\SingleObjects;

class Category extends ApiResource
{
    protected array $singleObjectLists = [
        'icons' => Image::class,
    ];

    public string $href;

    /**
     * @var array<Image>
     */
    public array $icons;

    public string $id;

    public string $name;
}
