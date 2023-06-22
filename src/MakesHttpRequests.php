<?php

namespace Spotify;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Spotify\Exceptions\BadRequestException;
use Spotify\Exceptions\ForbiddenException;
use Spotify\Exceptions\ResourceNotFoundException;
use Spotify\Exceptions\TooManyRequestsException;
use Spotify\Exceptions\UnauthorizedException;

trait MakesHttpRequests
{
    public function get(string $uri, array $payload = []): mixed
    {
        return $this->request('GET', $uri, $payload);
    }

    public function post(string $uri, array $payload = []): mixed
    {
        return $this->request('POST', $uri, $payload);
    }

    public function put(string $uri, array $payload = []): mixed
    {
        return $this->request('PUT', $uri, $payload);
    }

    public function patch(string $uri, array $payload = []): mixed
    {
        return $this->request('PATCH', $uri, $payload);
    }

    public function delete(string $uri, array $payload = []): mixed
    {
        return $this->request('DELETE', $uri, $payload);
    }

    public function request(string $verb, string $uri, mixed $payload = [], string $payloadType = 'json'): mixed
    {
        $verb = strtoupper($verb);

        $response = $this->client->request(
            $verb,
            $uri,
            empty($payload) ? [] : [($verb === 'GET' ? 'query' : $payloadType) => $payload]
        );

        if (!$this->isSuccessful($response)) {
            $this->handleRequestError($response);
        }

        $responseBody = (string) $response->getBody();

        return json_decode($responseBody, true) ?: $responseBody;
    }

    public function isSuccessful(ResponseInterface $response): bool
    {
        return (int) substr($response->getStatusCode(), 0, 1) === 2;
    }

    protected function handleRequestError(ResponseInterface $response): void
    {
        $body = (string) $response->getBody();

        throw match ($response->getStatusCode()) {
            400 => new BadRequestException($body),
            401 => new UnauthorizedException($body),
            403 => new ForbiddenException($body),
            404 => new ResourceNotFoundException(),
            429 => new TooManyRequestsException($body),
            default => new Exception($body),
        };
    }
}
