<?php

namespace Spotify\SingleObjects;

use Spotify\Support\PaginatedResults;

class Album extends ApiResource
{
    protected array $singleObjectLists = [
        'artists' => Artist::class,
        'copyrights' => Copyright::class,
        'images' => Image::class,
    ];

    protected array $paginatedResults = [
        'tracks' => Track::class,
    ];

    public string $albumType;

    public int $totalTracks;

    /**
     * @var array<string>
     */
    public array $availableMarkets;

    /**
     * @var array<string,string>
     */
    public array $externalUrls;

    public string $href;

    public string $id;

    /**
     * Undocumented in Spotify API
     */
    public ?bool $isPlayable = null;

    /**
     * @var array<Image>
     */
    public array $images;

    public string $name;

    public string $releaseDate;

    public string $releaseDatePrecision;

    /**
     * @var array<string, array<string,string>>
     */
    public array $restrictions;

    public string $type;

    public string $uri;

    /**
     * @var array<Copyright>
     */
    public array $copyrights;

    /**
     * @var array<string,string>
     */
    public array $externalIds;

    /**
     * @var array<string>
     */
    public array $genres;

    public string $label;

    public int $popularity;

    public ?string $albumGroup = null;

    /**
     * @var array<Artist>
     */
    public array $artists;

    /**
     * @var PaginatedResults<Track>
     */
    public PaginatedResults $tracks;
}
