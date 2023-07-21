<?php

namespace Tests\Resources;

use Spotify\SingleObjects\Episode;
use Spotify\SingleObjects\Image;
use Spotify\SingleObjects\SavedEpisode;
use Spotify\SingleObjects\Show;
use Spotify\Support\PaginatedResults;
use Tests\TestCase;

class EpisodesTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_a_single_episode()
    {
        $client = $this->mockClient('get', 'Episodes/Episode.json');

        $episode = $client->episodes()->find('some-id');

        $this->assertInstanceOf(Episode::class, $episode);
        $this->assertInstanceOf(Image::class, $episode->images[0]);
        $this->assertInstanceOf(Show::class, $episode->show);
    }

    /** @test */
    public function it_can_retrieve_multiple_episodes()
    {
        $client = $this->mockClient('get', 'Episodes/Multiple.json');

        $episodes = $client->episodes()->findMultiple(['some-id', 'some-id-2']);

        $this->assertInstanceOf(PaginatedResults::class, $episodes);
        $this->assertInstanceOf(Episode::class, $episodes[0]);
        $this->assertInstanceOf(Image::class, $episodes[0]->images[0]);
        $this->assertInstanceOf(Show::class, $episodes[0]->show);
    }

    /** @test */
    public function it_can_retrieve_user_saved_episodes()
    {
        $client = $this->mockClient('get', 'Episodes/SavedEpisodes.json');

        $episodes = $client->episodes()->findSaved();

        $this->assertInstanceOf(PaginatedResults::class, $episodes);
        $this->assertInstanceOf(SavedEpisode::class, $episodes[0]);
        $this->assertInstanceOf(Episode::class, $episodes[0]->episode);
        $this->assertEquals('string', $episodes[0]->addedAt);
    }
}
