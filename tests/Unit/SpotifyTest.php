<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Spotify\Client;
use Spotify\Spotify;

class SpotifyTest extends TestCase
{
    /** @test */
    public function it_may_create_a_client()
    {
        $spotify = Spotify::client('access-token');

        $this->assertInstanceOf(Client::class, $spotify);
    }
}
