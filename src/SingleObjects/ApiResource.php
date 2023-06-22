<?php

namespace Spotify\SingleObjects;

use Spotify\Support\PaginatedResults;

#[\AllowDynamicProperties]
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

        if (!empty($this->singleObjectLists)) {
            foreach ($this->singleObjectLists as $attribute => $mappingClass) {
                $this->mapToSingleObjectArray($attribute, $mappingClass);
            }
        }

        if (!empty($this->singleObjects)) {
            foreach ($this->singleObjects as $attribute => $mappingClass) {
                $this->mapToSingleObject($attribute, $mappingClass);
            }
        }

        if (!empty($this->paginatedResults)) {
            foreach ($this->paginatedResults as $attribute => $parameters) {
                $this->mapToPaginatedResults($attribute, $parameters);
            }
        }
    }

    protected function fill(): void
    {
        foreach ($this->attributes as $key => $value) {
            $key = $this->camelCase($key);

            $this->{$key} = $value;
        }
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        $publicProperties = get_object_vars($this);
        unset($publicProperties['attributes']);

        $properties = [];

        foreach ($publicProperties as $key => $value) {
            $properties[$this->snakeCase($key)] = $value;
        }

        return $properties;
    }

    protected function camelCase(string $string): string
    {
        $parts = explode('_', $string);

        foreach ($parts as $i => $part) {
            if ($i !== 0) {
                $parts[$i] = ucfirst($part);
            }
        }

        return str_replace(' ', '', implode(' ', $parts));
    }

    protected function snakeCase(string $string): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }

    protected function mapToSingleObjectArray(string $attribute, string $mappingClass): self
    {
        if (!property_exists($this, $attribute)) {
            return $this;
        }

        if (!is_array($this->{$attribute})) {
            return $this;
        }

        $this->{$attribute} = array_map(
            fn(array $attributes) => new $mappingClass($attributes),
            $this->{$attribute}
        );

        return $this;
    }

    protected function mapToSingleObject(string $attribute, string $mappingClass): self
    {
        if (!property_exists($this, $attribute)) {
            return $this;
        }

        $this->{$attribute} = new $mappingClass($this->{$attribute});

        return $this;
    }

    /**
     * @param  string|array<string, mixed>  $parameters
     */
    protected function mapToPaginatedResults(string $attribute, string|array $parameters): self
    {
        if (!property_exists($this, $attribute)) {
            return $this;
        }

        if (is_string($parameters)) {
            $parameters = ['mappingClass' => $parameters, 'entryKey' => $attribute];
        }

        $parameters['response'] = $this->attributes;

        $this->{$attribute} = new PaginatedResults(...$parameters);

        return $this;
    }
}
