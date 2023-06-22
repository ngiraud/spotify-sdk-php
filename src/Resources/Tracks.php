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
     * Get Spotify catalog information for a single or multiple tracks identified by their unique Spotify IDs.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-track
     *
     * @param  string|array<string>  $id
     *
     * @return Track|PaginatedResults<Track>
     */
    public function find(string|array $id, array $payload = []): Track|PaginatedResults
    {
        if (is_array($id)) {
            return $this->findMultiple($id, $payload);
        }

        return new Track($this->client->get("tracks/{$id}", $payload));
    }

    /**
     * Get Spotify catalog information for multiple tracks based on their Spotify IDs.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-several-tracks
     *
     * @param  array<string>  $ids
     *
     * @return PaginatedResults<Track>
     */
    public function findMultiple(array $ids, array $payload = []): PaginatedResults
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
     * Get a list of the songs saved in the current Spotify user's 'Your Music' library.
     *
     * @scope user-library-read
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
     * Save one or more tracks to the current user's 'Your Music' library.
     *
     * @scope user-library-modify
     * @see https://developer.spotify.com/documentation/web-api/reference/save-tracks-user
     *
     * @param  string|array<string>  $ids
     */
    public function save(string|array $ids): mixed
    {
        return $this->client->put(sprintf('me/tracks?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * Remove one or more tracks from the current user's 'Your Music' library.
     *
     * @scope user-library-modify
     * @see https://developer.spotify.com/documentation/web-api/reference/remove-tracks-user
     *
     * @param  string|array<string>  $ids
     */
    public function deleteSaved(string|array $ids): mixed
    {
        return $this->client->delete(sprintf('me/tracks?ids=%s', implode(',', (array) $ids)));
    }

    /**
     * Check if one or more tracks is already saved in the current Spotify user's 'Your Music' library.
     *
     * @scope user-library-read
     * @see https://developer.spotify.com/documentation/web-api/reference/check-users-saved-tracks
     *
     * @param  string|array<string>  $ids
     */
    public function checkSaved(string|array $ids): mixed
    {
        return $this->client->get('me/tracks/contains', ['ids' => implode(',', (array) $ids)]);
    }

    /**
     * Get audio feature information for a single or multiple tracks identified by their unique Spotify IDs.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-audio-features
     * @see https://developer.spotify.com/documentation/web-api/reference/get-several-audio-features
     *
     * @param  string|array<string>  $id
     *
     * @return AudioFeature|PaginatedResults<AudioFeature>
     */
    public function audioFeatures(string|array $id): AudioFeature|PaginatedResults
    {
        if (is_array($id)) {
            return PaginatedResults::make(
                endpoint: 'audio-features',
                mappingClass: AudioFeature::class,
                client: $this->client,
                payload: ['ids' => implode(',', array_filter((array) $id))],
                itemsKey: 'audio_features'
            );
        }

        return new AudioFeature($this->client->get("audio-features/{$id}"));
    }

    /**
     * Get a low-level audio analysis for a track in the Spotify catalog.
     * The audio analysis describes the track’s structure and musical content, including rhythm, pitch, and timbre.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-audio-analysis
     */
    public function audioAnalysis(string $id): AudioAnalysis
    {
        return new AudioAnalysis($this->client->get("audio-analysis/{$id}"));
    }

    /**
     * Recommendations are generated based on the available information for a given seed entity and matched against similar artists and tracks.
     * If there is sufficient information about the provided seeds, a list of tracks will be returned together with pool size details.
     * For artists and tracks that are very new or obscure there might not be enough data to generate a list of tracks.
     *
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
