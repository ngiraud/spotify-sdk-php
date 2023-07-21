<?php

namespace Spotify\SingleObjects;

use Spotify\Helpers\Arr;
use Spotify\Helpers\Str;
use Spotify\Support\PaginatedResults;

class ApiResource
{
    /**
     * @var array<string, mixed>
     */
    protected array $attributes = [];

    /**
     * @var array<string, string>
     */
    protected array $singleObjectLists = [];

    /**
     * @var array<string, string>
     */
    protected array $singleObjects = [];

    /**
     * @var array<string, string|array<string, mixed>>
     */
    protected array $paginatedResults = [];

    /**
     * @param  array<mixed>  $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;

        $this->fill();
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        $publicProperties = get_object_vars($this);
        unset($publicProperties['attributes']);
        unset($publicProperties['singleObjectLists']);
        unset($publicProperties['singleObjects']);
        unset($publicProperties['paginatedResults']);

        $properties = [];

        foreach ($publicProperties as $key => $value) {
            $properties[Str::snakeCase($key)] = $value;
        }

        return $properties;
    }

    protected function fill(): void
    {
        foreach ($this->attributes as $key => $value) {
            $key = Str::camelCase($key);

//            if (!property_exists($this, $key)) {
//                continue;
//            }

            $this->{$key} = $this->mapValue($key, $value);
        }
    }

    protected function mapValue(string $key, mixed $value): mixed
    {
        if (!empty($mappingClass = Arr::get($this->singleObjects, $key))) {
            return new $mappingClass($value);
        }

        if (!empty($mappingClass = Arr::get($this->singleObjectLists, $key))) {
            return array_map(
                fn(array $attributes) => new $mappingClass($attributes),
                $value
            );
        }

        if (!empty($parameters = Arr::get($this->paginatedResults, $key))) {
            if (is_string($parameters)) {
                $parameters = ['mappingClass' => $parameters, 'entryKey' => $key];
            }

            $parameters['response'] = $this->attributes;

            return new PaginatedResults(...$parameters);
        }

        return $value;
    }
}
