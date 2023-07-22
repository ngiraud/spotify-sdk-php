<?php

namespace Tests\Resources;

use Spotify\SingleObjects\Image;
use Spotify\SingleObjects\Playlist;
use Spotify\SingleObjects\PlaylistTrack;
use Spotify\SingleObjects\Track;
use Spotify\SingleObjects\User;
use Spotify\Support\PaginatedResults;
use Tests\TestCase;

class PlaylistsTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_a_single_playlist()
    {
        $client = $this->mockClient('get', 'Playlists/Playlist.json');

        $playlist = $client->playlists()->find('some-id');

        $this->assertInstanceOf(Playlist::class, $playlist);
        $this->assertInstanceOf(User::class, $playlist->owner);
        $this->assertInstanceOf(Image::class, $playlist->images[0]);
        $this->assertInstanceOf(PaginatedResults::class, $playlist->tracks);
    }

    /** @test */
    public function it_can_retrieve_playlist_items()
    {
        $client = $this->mockClient('get', 'Playlists/Items.json');

        $items = $client->playlists()->tracks('some-id');

        $this->assertInstanceOf(PaginatedResults::class, $items);
        $this->assertInstanceOf(PlaylistTrack::class, $items[0]);
        $this->assertInstanceOf(Track::class, $items[0]->track);
    }

    /** @test */
    public function it_can_retrieve_current_user_playlists()
    {
        $client = $this->mockClient('get', 'Playlists/CurrentUserPlaylists.json');

        $playlists = $client->playlists()->forCurrentUser();

        $this->assertInstanceOf(PaginatedResults::class, $playlists);
        $this->assertInstanceOf(Playlist::class, $playlists[0]);
    }

    /** @test */
    public function it_can_retrieve_user_playlists()
    {
        $client = $this->mockClient('get', 'Playlists/UserPlaylists.json');

        $playlists = $client->playlists()->forUser('some-id');

        $this->assertInstanceOf(PaginatedResults::class, $playlists);
        $this->assertInstanceOf(Playlist::class, $playlists[0]);
    }

    /** @test */
    public function it_can_retrieve_featured_playlists()
    {
        $client = $this->mockClient('get', 'Playlists/Featured.json');

        $playlists = $client->playlists()->featured();

        $this->assertInstanceOf(PaginatedResults::class, $playlists);
        $this->assertInstanceOf(Playlist::class, $playlists[0]);
    }

    /** @test */
    public function it_can_retrieve_playlists_by_category()
    {
        $client = $this->mockClient('get', 'Playlists/CategoryPlaylists.json');

        $playlists = $client->playlists()->forCategory('some-id');

        $this->assertInstanceOf(PaginatedResults::class, $playlists);
        $this->assertInstanceOf(Playlist::class, $playlists[0]);
    }

    /** @test */
    public function it_can_retrieve_playlist_cover_image()
    {
        $client = $this->mockClient('get', 'Playlists/CoverImage.json');

        $coverImages = $client->playlists()->coverImage('some-id');

        $this->assertIsArray($coverImages);
        $this->assertInstanceOf(Image::class, $coverImages[0]);
    }
}
