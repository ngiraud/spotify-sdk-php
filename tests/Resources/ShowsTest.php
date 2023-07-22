<?php

namespace Tests\Resources;

use Spotify\SingleObjects\Copyright;
use Spotify\SingleObjects\Episode;
use Spotify\SingleObjects\Image;
use Spotify\SingleObjects\SavedShow;
use Spotify\SingleObjects\Show;
use Spotify\Support\PaginatedResults;
use Tests\TestCase;

class ShowsTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_a_single_show()
    {
        $client = $this->mockClient('get', 'Shows/Show.json');

        $show = $client->shows()->find('some-id');

        $this->assertInstanceOf(Show::class, $show);
        $this->assertInstanceOf(Copyright::class, $show->copyrights[0]);
        $this->assertInstanceOf(Image::class, $show->images[0]);
        $this->assertInstanceOf(PaginatedResults::class, $show->episodes);
        $this->assertInstanceOf(Episode::class, $show->episodes[0]);
    }

    /** @test */
    public function it_can_retrieve_multiple_shows()
    {
        $client = $this->mockClient('get', 'Shows/Multiple.json');

        $shows = $client->shows()->findMultiple(['some-id', 'some-id-2']);

        $this->assertInstanceOf(PaginatedResults::class, $shows);
        $this->assertInstanceOf(Show::class, $shows[0]);
    }

    /** @test */
    public function it_can_retrieve_show_episodes()
    {
        $client = $this->mockClient('get', 'Shows/Episodes.json');

        $episodes = $client->shows()->episodes('some-id');

        $this->assertInstanceOf(PaginatedResults::class, $episodes);
        $this->assertInstanceOf(Episode::class, $episodes[0]);
    }

    /** @test */
    public function it_can_retrieve_user_saved_shows()
    {
        $client = $this->mockClient('get', 'Shows/SavedShows.json');

        $shows = $client->shows()->findSaved();

        $this->assertInstanceOf(PaginatedResults::class, $shows);
        $this->assertInstanceOf(SavedShow::class, $shows[0]);
        $this->assertInstanceOf(Show::class, $shows[0]->show);
        $this->assertEquals('string', $shows[0]->addedAt);
    }
}
