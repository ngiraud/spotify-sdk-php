<?php

namespace Spotify\SingleObjects;

class SavedAudiobook extends ApiResource
{
    protected array $singleObjectLists = [
        'authors' => Author::class,
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
}
