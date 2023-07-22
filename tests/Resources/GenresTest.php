<?php

namespace Tests\Resources;

use Tests\TestCase;

class GenresTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_genres()
    {
        $client = $this->mockClient('get', 'Genres/Seeds.json');

        $genres = $client->genres()->seeds();

        $this->assertIsArray($genres);
        $this->assertEquals('alternative', $genres[0]);
        $this->assertEquals('rock', $genres[1]);
    }
}
