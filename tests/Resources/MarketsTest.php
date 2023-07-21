<?php

namespace Tests\Resources;

use Tests\TestCase;

class MarketsTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_markets()
    {
        $client = $this->mockClient('get', 'Markets/Available.json');

        $markets = $client->markets()->all();

        $this->assertIsArray($markets);
        $this->assertEquals('CA', $markets[0]);
        $this->assertEquals('BR', $markets[1]);
        $this->assertEquals('IT', $markets[2]);
    }
}
