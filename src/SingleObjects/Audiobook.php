<?php

namespace Spotify\SingleObjects;

use Spotify\Support\PaginatedResults;

class Audiobook extends ApiResource
{
    protected array $singleObjectLists = [
        'authors' => Author::class,
        'copyrights' => Copyright::class,
        'images' => Image::class,
        'narrators' => Narrator::class,
    ];

    protected array $paginatedResults = [
        'chapters' => Chapter::class,
    ];

    /**
     * @var array<Author>
     */
    public array $authors;

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

    public string $edition;

    /**
     * @var array<Image>
     */
    public array $images;

    /**
     * @var array<string>
     */
    public array $languages;

    public string $mediaType;

    public string $name;

    /**
     * @var array<Narrator>
     */
    public array $narrators;

    public string $publisher;

    public string $type;

    public string $uri;

    public int $totalChapters;

    /**
     * @var PaginatedResults<Chapter>
     */
    public PaginatedResults $chapters;
}
