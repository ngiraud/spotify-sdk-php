<?php

namespace Spotify\SingleObjects;

class User extends ApiResource
{
    protected array $singleObjectLists = [
        'images' => Image::class,
    ];

    public ?string $country = null;

    public ?string $displayName = null;

    public ?string $email = null;

    /**
     * @var array<string,bool>
     */
    public array $explicitContent = [];

    /**
     * @var array<string,string>
     */
    public array $externalUrls;

    /**
     * @var array<string,string|int>
     */
    public array $followers;

    public string $href;

    public string $id;

    /**
     * @var array<Image>
     */
    public array $images = [];

    public ?string $product = null;

    public string $type;

    public string $uri;
}
