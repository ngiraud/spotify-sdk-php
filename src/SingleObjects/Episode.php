<?php

namespace Spotify\SingleObjects;

class Episode extends ApiResource
{
    protected array $singleObjectLists = [
        'images' => Image::class,
    ];

    protected array $singleObjects = [
        'show' => Show::class,
    ];

    public string $audioPreviewUrl;

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

    public bool $isExternallyHosted;

    public bool $isPlayable;

    /**
     * @deprecated  This field is deprecated and might be removed in the future. Please use the languages field instead.
     */
    public string $language = '';

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

    public Show $show;
}
