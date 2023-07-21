<?php

namespace Tests\Resources;

use Spotify\SingleObjects\Album;
use Spotify\SingleObjects\Artist;
use Spotify\SingleObjects\Image;
use Spotify\SingleObjects\Track;
use Spotify\Support\PaginatedResults;
use Tests\TestCase;

class ArtistsTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_a_single_artist()
    {
        $client = $this->mockClient('get', 'Artists/Artist.json');

        $artist = $client->artists()->find('some-id');

        $this->assertInstanceOf(Artist::class, $artist);
        $this->assertInstanceOf(Image::class, $artist->images[0]);
    }

    /** @test */
    public function it_can_retrieve_multiple_artists()
    {
        $client = $this->mockClient('get', 'Artists/Multiple.json');

        $artists = $client->artists()->findMultiple(['some-id', 'some-id-2']);

        $this->assertInstanceOf(PaginatedResults::class, $artists);
        $this->assertInstanceOf(Artist::class, $artists[0]);
    }

    /** @test */
    public function it_can_retrieve_artist_albums()
    {
        $client = $this->mockClient('get', 'Artists/Albums.json');

        $albums = $client->artists()->albums('some-id');

        $this->assertInstanceOf(PaginatedResults::class, $albums);
        $this->assertInstanceOf(Album::class, $albums[0]);
        $this->assertInstanceOf(Artist::class, $albums[0]->artists[0]);
    }

    /** @test */
    public function it_can_retrieve_artist_top_tracks()
    {
        $client = $this->mockClient('get', 'Artists/TopTracks.json');

        $tracks = $client->artists()->topTracks('some-id');

        $this->assertInstanceOf(PaginatedResults::class, $tracks);
        $this->assertInstanceOf(Track::class, $tracks[0]);
        $this->assertInstanceOf(Artist::class, $tracks[0]->artists[0]);
    }

    /** @test */
    public function it_can_retrieve_related_artists()
    {
        $client = $this->mockClient('get', 'Artists/RelatedArtists.json');

        $artists = $client->artists()->relatedArtists('some-id');

        $this->assertInstanceOf(PaginatedResults::class, $artists);
        $this->assertInstanceOf(Artist::class, $artists[0]);
        $this->assertInstanceOf(Image::class, $artists[0]->images[0]);
    }
}
