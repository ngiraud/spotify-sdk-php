<?php

namespace Spotify\Exceptions;

use Exception;

class ResourceNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('The resource you are looking for could not be found.');
    }
}
