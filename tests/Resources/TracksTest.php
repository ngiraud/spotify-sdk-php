<?php

namespace Tests\Resources;

use Spotify\SingleObjects\Album;
use Spotify\SingleObjects\Artist;
use Spotify\SingleObjects\AudioAnalysis;
use Spotify\SingleObjects\AudioFeature;
use Spotify\SingleObjects\SavedTrack;
use Spotify\SingleObjects\Track;
use Spotify\Support\PaginatedResults;
use Tests\TestCase;

class TracksTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_a_single_track()
    {
        $client = $this->mockClient('get', 'Tracks/Track.json');

        $track = $client->tracks()->find('some-id');

        $this->assertInstanceOf(Track::class, $track);
        $this->assertInstanceOf(Artist::class, $track->artists[0]);
        $this->assertInstanceOf(Album::class, $track->album);
    }

    /** @test */
    public function it_can_retrieve_multiple_tracks()
    {
        $client = $this->mockClient('get', 'Tracks/Multiple.json');

        $tracks = $client->tracks()->findMultiple(['some-id', 'some-id-2']);

        $this->assertInstanceOf(PaginatedResults::class, $tracks);
        $this->assertInstanceOf(Track::class, $tracks[0]);
    }

    /** @test */
    public function it_can_retrieve_user_saved_tracks()
    {
        $client = $this->mockClient('get', 'Tracks/SavedTracks.json');

        $tracks = $client->tracks()->findSaved();

        $this->assertInstanceOf(PaginatedResults::class, $tracks);
        $this->assertInstanceOf(SavedTrack::class, $tracks[0]);
        $this->assertInstanceOf(Track::class, $tracks[0]->track);
        $this->assertEquals('string', $tracks[0]->addedAt);
    }

    /** @test */
    public function it_can_retrieve_track_audio_features()
    {
        $client = $this->mockClient('get', 'Tracks/AudioFeature.json');

        $features = $client->tracks()->audioFeatures('some-id');

        $this->assertInstanceOf(AudioFeature::class, $features);
    }

    /** @test */
    public function it_can_retrieve_tracks_audio_features()
    {
        $client = $this->mockClient('get', 'Tracks/AudioFeatures.json');

        $features = $client->tracks()->audioFeatures(['some-id-1', 'some-id-2']);

        $this->assertInstanceOf(PaginatedResults::class, $features);
        $this->assertInstanceOf(AudioFeature::class, $features[0]);
    }

    /** @test */
    public function it_can_retrieve_track_audio_analysis()
    {
        $client = $this->mockClient('get', 'Tracks/AudioAnalysis.json');

        $analysis = $client->tracks()->audioAnalysis('some-id');

        $this->assertInstanceOf(AudioAnalysis::class, $analysis);
    }

    /** @test */
    public function it_can_retrieve_tracks_recommendations()
    {
        $client = $this->mockClient('get', 'Tracks/Recommendations.json');

        $recommendations = $client->tracks()->recommendations();

        $this->assertInstanceOf(PaginatedResults::class, $recommendations);
        $this->assertInstanceOf(Track::class, $recommendations[0]);
        $this->assertArrayHasKey('seeds', $recommendations->meta());
    }
}
