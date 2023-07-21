<?php

namespace Spotify;

class Spotify
{
    /**
     * Create a client with Authorization code flow
     *
     * @see https://developer.spotify.com/documentation/web-api/tutorials/code-flow
     */
    public static function client(string $accessToken): Client
    {
        return self::factory()
                   ->withAccessToken($accessToken)
                   ->make();
    }

    /**
     * Create a client with Client Credentials flow
     *
     * @see https://developer.spotify.com/documentation/web-api/tutorials/client-credentials-flow
     */
    public static function basic(string $clientId, string $clientSecret): Client
    {
        return self::factory()
                   ->authenticateBasic($clientId, $clientSecret)
                   ->make();
    }

    public static function factory(): Factory
    {
        return new Factory();
    }
}
