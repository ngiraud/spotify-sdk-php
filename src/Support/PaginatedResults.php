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
    /**
     * @var array<mixed>
     */
    protected array $results;

    /**
     * @var array<mixed>
     */
    protected array $links = [];

    /**
     * @var array<mixed>
     */
    protected array $meta = [];

    /**
     * @param  array<mixed>  $response
     */
    public function __construct(
        protected array $response,
        protected string $mappingClass,
        protected string $itemsKey = 'items',
        protected ?string $entryKey = null
    ) {
        $this->mapResults();

        $this->setLinks();

        $this->setMeta();
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function make(
        string $endpoint,
        string $mappingClass,
        Client $client,
        array $payload = [],
        string $itemsKey = 'items',
        ?string $entryKey = null
    ): self {
        return new self(
            $client->get($endpoint, $payload),
            $mappingClass,
            $itemsKey,
            $entryKey
        );
    }

    /**
     * @return array<mixed>
     */
    public function results(): array
    {
        return $this->results;
    }

    /**
     * @return array<mixed>
     */
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

    public function previous(Client $client): ?self
    {
        if (! $previousUrl = $this->previousUrl()) {
            return null;
        }

        return PaginatedResults::make(
            endpoint: $previousUrl,
            mappingClass: $this->mappingClass,
            client: $client,
            itemsKey: $this->itemsKey,
            entryKey: $this->entryKey
        );
    }

    public function next(Client $client): ?self
    {
        if (! $nextUrl = $this->nextUrl()) {
            return null;
        }

        return PaginatedResults::make(
            endpoint: $nextUrl,
            mappingClass: $this->mappingClass,
            client: $client,
            itemsKey: $this->itemsKey,
            entryKey: $this->entryKey
        );
    }

    /**
     * @return array<mixed>
     */
    public function meta(): array
    {
        return $this->meta;
    }

    public function total(): ?int
    {
        return Arr::get($this->meta, 'total');
    }

    protected function mapResults(): self
    {
        $this->results = array_map(
            fn ($attributes) => new $this->mappingClass($attributes),
            Arr::get(Arr::get($this->response, $this->entryKey, []), $this->itemsKey, []),
        );

        return $this;
    }

    protected function setLinks(): self
    {
        $this->links = Arr::only(
            Arr::get($this->response, $this->entryKey, []),
            ['next', 'previous']
        );

        return $this;
    }

    protected function setMeta(): self
    {
        $this->meta = Arr::only(
            Arr::get($this->response, $this->entryKey, []),
            ['href', 'limit', 'offset', 'total', 'seeds', 'cursors']
        );

        return $this;
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
