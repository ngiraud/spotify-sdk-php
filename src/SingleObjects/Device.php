<?php

namespace Spotify\SingleObjects;

class Device extends ApiResource
{
    public string $id;

    public bool $isActive;

    public bool $isPrivateSession;

    public bool $isRestricted;

    public string $name;

    public string $type;

    public int $volumePercent;
}
