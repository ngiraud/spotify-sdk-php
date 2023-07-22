<?php

namespace Tests\Resources;

use Spotify\SingleObjects\Device;
use Spotify\SingleObjects\PlaybackState;
use Spotify\SingleObjects\PlayHistory;
use Spotify\SingleObjects\Track;
use Spotify\SingleObjects\UserQueue;
use Spotify\Support\PaginatedResults;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_the_playback_state()
    {
        $client = $this->mockClient('get', 'Player/PlaybackState.json');

        $state = $client->player()->state();

        $this->assertInstanceOf(PlaybackState::class, $state);
        $this->assertInstanceOf(Device::class, $state->device);
        $this->assertInstanceOf(Track::class, $state->item);
    }

    /** @test */
    public function it_can_retrieve_available_devices()
    {
        $client = $this->mockClient('get', 'Player/AvailableDevices.json');

        $devices = $client->player()->availableDevices();

        $this->assertIsArray($devices);
        $this->assertInstanceOf(Device::class, $devices[0]);
    }

    /** @test */
    public function it_can_retrieve_the_currently_playing_track()
    {
        $client = $this->mockClient('get', 'Player/CurrentlyPlayingTrack.json');

        $currentlyPlaying = $client->player()->currentlyPlayingTrack();

        $this->assertInstanceOf(PlaybackState::class, $currentlyPlaying);
        $this->assertInstanceOf(Device::class, $currentlyPlaying->device);
        $this->assertInstanceOf(Track::class, $currentlyPlaying->item);
    }

    /** @test */
    public function it_can_retrieve_recently_played_tracks()
    {
        $client = $this->mockClient('get', 'Player/RecentlyPlayedTracks.json');

        $history = $client->player()->recentlyPlayedTracks();

        $this->assertInstanceOf(PaginatedResults::class, $history);
        $this->assertInstanceOf(PlayHistory::class, $history[0]);
        $this->assertInstanceOf(Track::class, $history[0]->track);
        $this->assertEquals('string', $history[0]->playedAt);
    }

    /** @test */
    public function it_can_retrieve_the_user_queue()
    {
        $client = $this->mockClient('get', 'Player/UserQueue.json');

        $queue = $client->player()->queue();

        $this->assertInstanceOf(UserQueue::class, $queue);
        $this->assertInstanceOf(Track::class, $queue->currentlyPlaying);
        $this->assertIsArray($queue->queue);
        $this->assertInstanceOf(Track::class, $queue->queue[0]);
    }
}
