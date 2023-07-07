<?php

namespace Spotify\Exceptions;

use Exception;

class UnableToAuthenticateException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
