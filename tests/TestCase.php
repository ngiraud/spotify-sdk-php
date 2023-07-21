<?php

namespace Tests;

use Mockery;
use Spotify\Client;
use Spotify\Factory;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    public function mockClient(string $method, string $fixturePath): Client
    {
        $factory = Mockery::mock(Factory::class);

        $factory->shouldReceive($method)
                ->once()
                ->andReturn(json_decode(file_get_contents("tests/Fixtures/{$fixturePath}"), true));

        return new Client($factory);
    }
}
