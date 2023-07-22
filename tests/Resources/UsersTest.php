<?php

namespace Tests\Resources;

use Spotify\SingleObjects\Artist;
use Spotify\SingleObjects\Image;
use Spotify\SingleObjects\Track;
use Spotify\SingleObjects\User;
use Spotify\Support\PaginatedResults;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_current_profile()
    {
        $client = $this->mockClient('get', 'Users/Me.json');

        $me = $client->users()->me();

        $this->assertInstanceOf(User::class, $me);
        $this->assertInstanceOf(Image::class, $me->images[0]);
    }

    /** @test */
    public function it_can_retrieve_user_profile()
    {
        $client = $this->mockClient('get', 'Users/Profile.json');

        $profile = $client->users()->profile('some-id');

        $this->assertInstanceOf(User::class, $profile);
    }

    /** @test */
    public function it_can_retrieve_user_top_artists()
    {
        $client = $this->mockClient('get', 'Users/TopArtists.json');

        $items = $client->users()->topArtists();

        $this->assertInstanceOf(PaginatedResults::class, $items);
        $this->assertInstanceOf(Artist::class, $items[0]);
    }

    /** @test */
    public function it_can_retrieve_user_top_tracks()
    {
        $client = $this->mockClient('get', 'Users/TopTracks.json');

        $items = $client->users()->topTracks();

        $this->assertInstanceOf(PaginatedResults::class, $items);
        $this->assertInstanceOf(Track::class, $items[0]);
    }

    /** @test */
    public function it_can_retrieve_followed_artists()
    {
        $client = $this->mockClient('get', 'Users/FollowedArtists.json');

        $artists = $client->users()->followedArtists();

        $this->assertInstanceOf(PaginatedResults::class, $artists);
        $this->assertInstanceOf(Artist::class, $artists[0]);
    }
}
