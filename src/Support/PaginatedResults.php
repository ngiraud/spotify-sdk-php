<?php

namespace Spotify\Support;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Spotify\Client;
use Spotify\Helpers\Arr;
use Traversable;

class PaginatedResults implements ArrayAccess, IteratorAggregate
{
    public static function make(
        string $endpoint,
        string $mappingClass,
        Client $client,
        array $payload = [],
        string $itemsKey = 'items',
        ?string $entryKey = null
    ): self {
        $response = $client->get($endpoint, $payload);

        $results = array_map(
            fn ($attributes) => new $mappingClass($attributes),
            Arr::get(Arr::get($response, $entryKey), $itemsKey),
        );

        return new self(
            $results,
            Arr::only(Arr::get($response, $entryKey), ['next', 'previous']),
            Arr::only(Arr::get($response, $entryKey), ['href', 'limit', 'offset', 'total', 'seeds', 'cursors']),
            $client,
            $mappingClass,
            $payload,
            $itemsKey,
            $entryKey
        );
    }

    public function __construct(
        protected array $results,
        protected array $links,
        protected array $meta,
        protected Client $client,
        protected string $mappingClass,
        protected array $payload = [],
        protected string $itemsKey = 'items',
        protected ?string $entryKey = null
    ) {
    }

    public function results(): array
    {
        return $this->results;
    }

    public function links(): array
    {
        return $this->links;
    }

    public function previousUrl(): ?string
    {
        return Arr::get($this->links, 'previous');
    }

    public function nextUrl(): ?string
    {
        return Arr::get($this->links, 'next');
    }

    public function previous(): ?self
    {
        if (! $previousUrl = $this->previousUrl()) {
            return null;
        }

        return PaginatedResults::make(
            endpoint: $previousUrl,
            mappingClass: $this->mappingClass,
            client: $this->client,
            itemsKey: $this->itemsKey,
            entryKey: $this->entryKey
        );
    }

    public function next(): ?self
    {
        if (! $nextUrl = $this->nextUrl()) {
            return null;
        }

        return PaginatedResults::make(
            endpoint: $nextUrl,
            mappingClass: $this->mappingClass,
            client: $this->client,
            itemsKey: $this->itemsKey,
            entryKey: $this->entryKey
        );
    }

    public function meta(): array
    {
        return $this->meta;
    }

    public function total(): int
    {
        return Arr::get($this->meta, 'total');
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->results[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->results[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->results[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->results[$offset]);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->results);
    }
}
