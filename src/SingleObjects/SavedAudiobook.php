<?php

namespace Spotify\SingleObjects;

class SavedAudiobook extends ApiResource
{
    protected array $singleObjects = [
        'audiobook' => Audiobook::class,
    ];
}
