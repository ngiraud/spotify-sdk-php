<?php

namespace Spotify\SingleObjects;

use Spotify\Support\PaginatedResults;

class Show extends ApiResource
{
    protected array $singleObjectLists = [
        'copyrights' => Copyright::class,
        'images' => Image::class,
    ];

    protected array $paginatedResults = [
        'episodes' => Episode::class,
    ];

    /**
     * @var array<string>
     */
    public array $availableMarkets;

    /**
     * @var array<Copyright>
     */
    public array $copyrights;

    public string $description;

    public string $htmlDescription;

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

    /**
     * @var array<string>
     */
    public array $languages;

    public string $mediaType;

    public string $name;

    public string $publisher;

    public string $type;

    public string $uri;

    public int $totalEpisodes;

    /**
     * @var PaginatedResults<Episode>
     */
    public PaginatedResults $episodes;
}
