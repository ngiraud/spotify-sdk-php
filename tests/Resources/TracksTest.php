<?php

namespace Tests\Resources;

use Spotify\SingleObjects\Track;
use Tests\TestCase;

class TracksTest extends TestCase
{
    /** @test */
    public function it_can_find_a_single_track()
    {
        $client = $this->mockClient('get', 'Tracks/Find.json');

        $track = $client->tracks()->find('some-id');

        $this->assertInstanceOf(Track::class, $track);
    }
}
