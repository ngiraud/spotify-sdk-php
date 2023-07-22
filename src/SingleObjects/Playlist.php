<?php

namespace Spotify\SingleObjects;

use Spotify\Support\PaginatedResults;

class Playlist extends ApiResource
{
    protected array $singleObjectLists = [
        'images' => Image::class,
    ];

    protected array $singleObjects = [
        'owner' => User::class,
    ];

    protected array $paginatedResults = [
        'tracks' => PlaylistTrack::class,
    ];

    public bool $collaborative;

    public ?string $description = null;

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
    public array $images;

    public string $name;

    public User $owner;

    public ?bool $public = null;

    public string $snapshotId;

    /**
     * @var PaginatedResults<PlaylistTrack>
     */
    public PaginatedResults $tracks;

    public string $type;

    public string $uri;

    public ?string $primaryColor = null;
}
