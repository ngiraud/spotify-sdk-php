<?php

namespace Tests\Resources;

use Spotify\SingleObjects\Album;
use Spotify\SingleObjects\Artist;
use Spotify\SingleObjects\Copyright;
use Spotify\SingleObjects\Image;
use Spotify\SingleObjects\SavedAlbum;
use Spotify\SingleObjects\Track;
use Spotify\Support\PaginatedResults;
use Tests\TestCase;

class AlbumsTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_a_single_album()
    {
        $client = $this->mockClient('get', 'Albums/Album.json');

        $album = $client->albums()->find('some-id');

        $this->assertInstanceOf(Album::class, $album);
        $this->assertInstanceOf(Copyright::class, $album->copyrights[0]);
        $this->assertInstanceOf(Artist::class, $album->artists[0]);
        $this->assertInstanceOf(Image::class, $album->images[0]);
    }

    /** @test */
    public function it_can_retrieve_multiple_albums()
    {
        $client = $this->mockClient('get', 'Albums/Multiple.json');

        $albums = $client->albums()->findMultiple(['some-id', 'some-id-2']);

        $this->assertInstanceOf(PaginatedResults::class, $albums);
        $this->assertInstanceOf(Album::class, $albums[0]);
    }

    /** @test */
    public function it_can_retrieve_album_tracks()
    {
        $client = $this->mockClient('get', 'Albums/Tracks.json');

        $tracks = $client->albums()->tracks('some-id');

        $this->assertInstanceOf(PaginatedResults::class, $tracks);
        $this->assertInstanceOf(Track::class, $tracks[0]);
        $this->assertInstanceOf(Artist::class, $tracks[0]->artists[0]);
    }

    /** @test */
    public function it_can_retrieve_user_saved_albums()
    {
        $client = $this->mockClient('get', 'Albums/SavedAlbums.json');

        $albums = $client->albums()->findSaved();

        $this->assertInstanceOf(PaginatedResults::class, $albums);
        $this->assertInstanceOf(SavedAlbum::class, $albums[0]);
        $this->assertInstanceOf(Album::class, $albums[0]->album);
        $this->assertEquals('string', $albums[0]->addedAt);
    }

    /** @test */
    public function it_can_retrieve_new_releases()
    {
        $client = $this->mockClient('get', 'Albums/NewReleases.json');

        $albums = $client->albums()->newReleases();

        $this->assertInstanceOf(PaginatedResults::class, $albums);
        $this->assertInstanceOf(Album::class, $albums[0]);
    }
}
