<?php

namespace Spotify\SingleObjects;

class AudioFeature extends ApiResource
{
    public float $acousticness;

    public string $analysisUrl;

    public float $danceability;

    public int $durationMs;

    public float $energy;

    public string $id;

    public float $instrumentalness;

    public int $key;

    public float $liveness;

    public float $loudness;

    public int $mode;

    public float $speechiness;

    public float $tempo;

    public int $timeSignature;

    public string $trackHref;

    public string $type;

    public string $uri;

    public float $valence;
}
