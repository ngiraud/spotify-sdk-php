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
        string $itemsKey = 'items'
    ): self {
        $response = $client->get($endpoint, $payload);

        $results = array_map(
            fn ($attributes) => new $mappingClass($attributes),
            Arr::get($response, $itemsKey),
        );

        return new self(
            $results,
            Arr::only($response, ['next', 'previous']),
            Arr::only($response, ['href', 'limit', 'offset', 'total']),
            $client,
            $mappingClass,
            $payload
        );
    }

    public function __construct(
        protected array $results,
        protected array $links,
        protected array $meta,
        protected Client $client,
        protected string $mappingClass,
        protected array $payload = [],
        protected string $itemsKey = 'items'
    ) {
    }

    public function results(): array
    {
        return $this->results;
    }

    public function previousUrl(): ?string
    {
        return $this->links['previous'];
    }

    public function nextUrl(): ?string
    {
        return $this->links['next'];
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
        );
    }

    public function meta(): array
    {
        return $this->meta;
    }

    public function total(): int
    {
        return $this->meta['total'];
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
