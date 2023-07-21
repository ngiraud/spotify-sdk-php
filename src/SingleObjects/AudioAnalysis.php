<?php

namespace Spotify\SingleObjects;

class AudioAnalysis extends ApiResource
{
    /**
     * @var array<string,mixed>
     */
    public array $meta;

    /**
     * @var array<string,mixed>
     */
    public array $track;

    /**
     * @var array<string,mixed>
     */
    public array $bars;

    /**
     * @var array<string,mixed>
     */
    public array $beats;

    /**
     * @var array<string,mixed>
     */
    public array $sections;

    /**
     * @var array<string,mixed>
     */
    public array $segments;

    /**
     * @var array<string,mixed>
     */
    public array $tatums;
}
