<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\Audiobook;
use Spotify\SingleObjects\Chapter;
use Spotify\SingleObjects\SavedAudiobook;
use Spotify\Support\PaginatedResults;

class Audiobooks extends SpotifyResource
{
    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-an-audiobook
     *
     * @param  string|array<string>  $id
     * @return Audiobook|PaginatedResults<Audiobook>
     */
    public function find(string|array $id, array $payload = []): Audiobook|PaginatedResults
    {
        if (is_array($id)) {
            return $this->findMultiple($id, $payload);
        }

        return new Audiobook($this->client->get("audiobooks/{$id}", $payload));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-multiple-audiobooks
     *
     * @param  array<string>  $ids
     * @return PaginatedResults<Audiobook>
     */
    public function findMultiple(array $ids, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'audiobooks',
            mappingClass: Audiobook::class,
            client: $this->client,
            payload: ['ids' => implode(',', array_filter($ids)), ...$payload],
            itemsKey: 'audiobooks',
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-audiobook-chapters
     */
    public function chapters(string $id, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: "audiobooks/{$id}/chapters",
            mappingClass: Chapter::class,
            client: $this->client,
            payload: $payload
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-saved-audiobooks
     *
     * @return PaginatedResults<SavedAudiobook>
     */
    public function findSaved(array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'me/audiobooks',
            mappingClass: SavedAudiobook::class,
            client: $this->client,
            payload: $payload,
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/save-audiobooks-user
     *
     * @param  string|array<string>  $ids
     */
    public function save(string|array $ids): mixed
    {
        return $this->client->put(sprintf('me/audiobooks?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/remove-audiobooks-user
     *
     * @param  string|array<string>  $ids
     */
    public function deleteSaved(string|array $ids): mixed
    {
        return $this->client->delete(sprintf('me/audiobooks?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/check-users-saved-audiobooks
     *
     * @param  string|array<string>  $ids
     */
    public function checkSaved(string|array $ids): mixed
    {
        return $this->client->get('me/audiobooks/contains', ['ids' => implode(',', (array) $ids)]);
    }
}
