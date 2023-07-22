<?php

namespace Spotify\SingleObjects;

class Artist extends ApiResource
{
    protected array $singleObjectLists = [
        'images' => Image::class,
    ];

    /**
     * @var array<string,string>
     */
    public array $externalUrls;

    /**
     * @var array<string,string|int>
     */
    public array $followers;

    /**
     * @var array<string>
     */
    public array $genres;

    public string $href;

    public string $id;

    /**
     * @var array<Image>
     */
    public array $images;

    public string $name;

    public int $popularity;

    public string $type;

    public string $uri;
}
