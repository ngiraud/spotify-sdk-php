<?php

namespace Spotify\SingleObjects;

class Track extends ApiResource
{
    protected array $singleObjectLists = [
        'artists' => Artist::class,
    ];

    protected array $singleObjects = [
        'album' => Album::class,
    ];

    public Album $album;

    /**
     * @var array<Artist>
     */
    public array $artists;

    /**
     * @var array<string>
     */
    public array $availableMarkets;

    public int $discNumber;

    public int $durationMs;

    public bool $explicit;

    /**
     * @var array<string,string>
     */
    public array $externalIds;

    /**
     * @var array<string,string>
     */
    public array $externalUrls;

    public string $href;

    public string $id;

    public bool $isPlayable;

    /**
     * @var array<string, string>
     */
    public array $linkedFrom;

    /**
     * @var array<string, array<string,string>>
     */
    public array $restrictions;

    public string $name;

    public int $popularity;

    public string $previewUrl;

    public int $trackNumber;

    public string $type;

    public string $uri;

    public bool $isLocal;
}
