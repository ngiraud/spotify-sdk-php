<?php

namespace Spotify;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Spotify\Exceptions\BadRequestException;
use Spotify\Exceptions\ForbiddenException;
use Spotify\Exceptions\ResourceNotFoundException;
use Spotify\Exceptions\UnauthorizedException;

trait MakesHttpRequests
{
    public function get(string $uri, array $payload = [])
    {
        return $this->request('GET', $uri, $payload);
    }

    public function post(string $uri, array $payload = [])
    {
        return $this->request('POST', $uri, $payload);
    }

    public function put(string $uri, array $payload = [])
    {
        return $this->request('PUT', $uri, $payload);
    }

    public function patch(string $uri, array $payload = [])
    {
        return $this->request('PATCH', $uri, $payload);
    }

    public function delete(string $uri, array $payload = [])
    {
        return $this->request('DELETE', $uri, $payload);
    }

    public function request(string $verb, string $uri, array $payload = []): mixed
    {
        $response = $this->client->request(
            $verb,
            $uri,
            empty($payload) ? [] : [$verb === 'GET' ? 'query' : 'form_params' => $payload]
        );

        if (!$this->isSuccessful($response)) {
            $this->handleRequestError($response);

            return null;
        }

        $responseBody = (string) $response->getBody();

        return json_decode($responseBody, true) ?: $responseBody;
    }

    public function isSuccessful($response): bool
    {
        if (!$response) {
            return false;
        }

        return (int) substr($response->getStatusCode(), 0, 1) === 2;
    }

    protected function buildFilterString(array $filters): string
    {
        if (count($filters) === 0) {
            return '';
        }

        $preparedFilters = [];

        foreach ($filters as $name => $value) {
            $preparedFilters["filter[{$name}]"] = $value;
        }

        return '?'.http_build_query($preparedFilters);
    }

    protected function handleRequestError(ResponseInterface $response): void
    {
        $body = (string) $response->getBody();

        throw match ($response->getStatusCode()) {
            404 => new ResourceNotFoundException(),
            400 => new BadRequestException($body),
            401 => new UnauthorizedException($body),
            403 => new ForbiddenException($body),
            default => new Exception($body),
        };
    }
}
