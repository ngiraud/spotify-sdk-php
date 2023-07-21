<?php

namespace Spotify\Support;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Spotify\Factory;
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
        Factory $factory,
        array $payload = [],
        string $itemsKey = 'items',
        ?string $entryKey = null
    ): self {
        return new self(
            $factory->get($endpoint, $payload),
            $mappingClass,
            $itemsKey,
            $entryKey
        );
    }

    /**
     * Get the results.
     * A results object is also iterable, so you can also get to the results by simply using the object in a loop.
     *
     * @return array<mixed>
     */
    public function results(): array
    {
        return $this->results;
    }

    /**
     * Get the previous and next URL that will be called to get results.
     *
     * @return array<mixed>
     */
    public function links(): array
    {
        return $this->links;
    }

    /**
     * Get the URL that will be called to get the previous page of results.
     */
    public function previousUrl(): ?string
    {
        return Arr::get($this->links, 'previous');
    }

    /**
     * Get the URL that will be called to get the next page of results.
     */
    public function nextUrl(): ?string
    {
        return Arr::get($this->links, 'next');
    }

    /**
     * Fetch the previous page of results.
     */
    public function previous(Factory $factory): ?self
    {
        if (!$previousUrl = $this->previousUrl()) {
            return null;
        }

        return PaginatedResults::make(
            endpoint: $previousUrl,
            mappingClass: $this->mappingClass,
            factory: $factory,
            itemsKey: $this->itemsKey,
            entryKey: $this->entryKey
        );
    }

    /**
     * Fetch the next page of results.
     */
    public function next(Factory $factory): ?self
    {
        if (!$nextUrl = $this->nextUrl()) {
            return null;
        }

        return PaginatedResults::make(
            endpoint: $nextUrl,
            mappingClass: $this->mappingClass,
            factory: $factory,
            itemsKey: $this->itemsKey,
            entryKey: $this->entryKey
        );
    }

    /**
     * Returns a list of meta like total, limit, offset, href, seeds, cursors.
     *
     * @return array<mixed>
     */
    public function meta(): array
    {
        return $this->meta;
    }

    /**
     * Get the total number of results across all pages.
     */
    public function total(): ?int
    {
        return Arr::get($this->meta, 'total');
    }

    /**
     * Map results to their according mapping class
     */
    protected function mapResults(): self
    {
        $this->results = array_map(
            fn($attributes) => new $this->mappingClass($attributes),
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
