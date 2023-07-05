<?php

namespace Spotify\Exceptions;

use Exception;

class AccessTokenRequiredException extends Exception
{
    public function __construct()
    {
        parent::__construct('An access token is required in order to use the Spotify API.');
    }
}
