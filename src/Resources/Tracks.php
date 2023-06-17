<?php

namespace Spotify\Resources;

use Spotify\SingleObjects\AudioAnalysis;
use Spotify\SingleObjects\AudioFeature;
use Spotify\SingleObjects\SavedAlbum;
use Spotify\SingleObjects\SavedTrack;
use Spotify\SingleObjects\Track;
use Spotify\Support\PaginatedResults;

class Tracks extends SpotifyResource
{
    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-track
     *
     * @param  string|array<string>  $id
     * @return Track|PaginatedResults<Track>
     */
    public function find(string|array $id, array $payload): Track|PaginatedResults
    {
        if (is_array($id)) {
            return $this->findMultiple($id, $payload);
        }

        return new Track($this->client->get("tracks/{$id}", $payload));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-several-tracks
     *
     * @param  array<string>  $ids
     * @return PaginatedResults<Track>
     */
    public function findMultiple(array $ids, array $payload): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'tracks',
            mappingClass: Track::class,
            client: $this->client,
            payload: ['ids' => implode(',', array_filter($ids)), ...$payload],
            itemsKey: 'tracks',
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-saved-tracks
     *
     * @return PaginatedResults<SavedTrack>
     */
    public function findSaved(array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'me/tracks',
            mappingClass: SavedTrack::class,
            client: $this->client,
            payload: $payload,
        );
    }

    /**
     * IDs passed in the body seems not to be saved, even with the "Try it" from the docs.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/save-tracks-user
     *
     * @param  string|array<string>  $ids
     */
    public function save(string|array $ids): mixed
    {
        $ids = (array) $ids;

        return $this->client->put(
            sprintf('me/tracks?ids=%s', implode(',', array_slice($ids, 0, 20))),
            count($ids) > 20 ? ['ids' => array_slice($ids, 20)] : []
        );
    }

    /**
     * IDs passed in the body seems not to be saved, even with the "Try it" from the docs.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/remove-tracks-user
     *
     * @param  string|array<string>  $ids
     */
    public function deleteSaved(string|array $ids): mixed
    {
        $ids = (array) $ids;

        return $this->client->delete(
            sprintf('me/tracks?ids=%s', implode(',', array_slice($ids, 0, 20))),
            count($ids) > 20 ? ['ids' => array_slice($ids, 20)] : []
        );
    }

    /**
     * IDs passed in the body seems not to be saved, even with the "Try it" from the docs.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/check-users-saved-tracks
     *
     * @param  string|array<string>  $ids
     */
    public function checkSaved(string|array $ids): mixed
    {
        return $this->client->get('me/tracks/contains', ['ids' => implode(',', (array) $ids)]);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-audio-features
     *
     * @param  string|array<string>  $id
     * @return AudioFeature|PaginatedResults<Track>
     */
    public function audioFeature(string|array $id): AudioFeature|PaginatedResults
    {
        if (is_array($id)) {
            return $this->audioFeatures($id);
        }

        return new AudioFeature($this->client->get("audio-features/{$id}"));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-several-audio-features
     *
     * @return PaginatedResults<AudioFeature>
     */
    public function audioFeatures(string|array $ids): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'audio-features',
            mappingClass: AudioFeature::class,
            client: $this->client,
            payload: ['ids' => implode(',', array_filter((array) $ids))],
            itemsKey: 'audio_features'
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-audio-analysis
     */
    public function audioAnalysis(string $id): AudioAnalysis
    {
        return new AudioAnalysis($this->client->get("audio-analysis/{$id}"));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-recommendations
     *
     * @return PaginatedResults<SavedAlbum>
     */
    public function recommendations(array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'recommendations',
            mappingClass: Track::class,
            client: $this->client,
            payload: $payload,
            itemsKey: 'tracks'
        );
    }
}
