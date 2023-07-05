<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Spotify\Client;
use Spotify\Exceptions\AccessTokenRequiredException;

class ClientTest extends TestCase
{
    /** @test */
    public function it_throws_an_exception_if_no_access_token_is_provided()
    {
        $this->expectExceptionObject(new AccessTokenRequiredException());

        new Client();
    }
}
