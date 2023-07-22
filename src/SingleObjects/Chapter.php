<?php

namespace Spotify\SingleObjects;

class Chapter extends ApiResource
{
    protected array $singleObjectLists = [
        'images' => Image::class,
    ];

    protected array $singleObjects = [
        'audiobook' => Audiobook::class,
    ];

    public string $audioPreviewUrl;

    /**
     * @var array<string>
     */
    public array $availableMarkets;

    public int $chapterNumber;

    public string $description;

    public string $htmlDescription;

    public int $durationMs;

    public bool $explicit;

    /**
     * @var array<string,string>
     */
    public array $externalUrls;

    public string $href;

    public string $id;

    /**
     * @var array<Image>
     */
    public array $images;

    public bool $isPlayable;

    /**
     * @var array<string>
     */
    public array $languages;

    public string $name;

    public string $releaseDate;

    public string $releaseDatePrecision;

    /**
     * @var array<string,int|bool>
     */
    public array $resumePoint;

    public string $type;

    public string $uri;

    /**
     * @var array<string,string>
     */
    public array $restrictions;

    public Audiobook $audiobook;
}
