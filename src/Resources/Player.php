<?php

namespace Spotify\Resources;

use Spotify\Helpers\Arr;
use Spotify\SingleObjects\Device;
use Spotify\SingleObjects\Player as PlayerSingleObject;
use Spotify\SingleObjects\PlayHistory;
use Spotify\Support\PaginatedResults;

class Player extends SpotifyResource
{
    /**
     * Get information about the user’s current playback state, including track or episode, progress, and active device.
     *
     * @scope user-read-playback-state
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-information-about-the-users-current-playback
     *
     * @param  array<string, string>  $payload
     */
    public function state(array $payload = []): mixed
    {
        return new PlayerSingleObject($this->client->get('me/player', $payload));
    }

    /**
     * Transfer playback to a new device and determine if it should start playing.
     *
     * @scope user-modify-playback-state
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/transfer-a-users-playback
     *
     * @param  array<string>  $deviceIds
     */
    public function transfer(array $deviceIds, bool $play = false): mixed
    {
        return $this->client->put('me/player', [
            'device_ids' => $deviceIds,
            'play' => $play,
        ]);
    }

    /**
     * Get information about a user’s available devices.
     *
     * @scope user-read-playback-state
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-a-users-available-devices
     */
    public function availableDevices(): mixed
    {
        return array_map(
            fn ($attributes) => new Device($attributes),
            Arr::get((array) $this->client->get('me/player/devices'), 'devices', [])
        );
    }

    /**
     * Get the object currently being played on the user's Spotify account.
     *
     * @scope user-read-currently-playing
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-the-users-currently-playing-track
     *
     * @param  array<string, string>  $payload
     */
    public function currentlyPlayingTrack(array $payload = []): mixed
    {
        return new PlayerSingleObject($this->client->get('me/player/currently-playing', $payload));
    }

    /**
     * Start a new context or resume current playback on the user's active device.
     *
     * @scope user-modify-playback-state
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/start-a-users-playback
     */
    public function start(?string $deviceId = null): mixed
    {
        return $this->client->put('me/player/play', ['device_id' => $deviceId]);
    }

    /**
     * Pause playback on the user's account.
     *
     * @scope user-modify-playback-state
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/pause-a-users-playback
     */
    public function pause(?string $deviceId = null): mixed
    {
        return $this->client->put('me/player/pause', ['device_id' => $deviceId]);
    }

    /**
     * Skips to next track in the user’s queue.
     *
     * @scope user-modify-playback-state
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/skip-users-playback-to-next-track
     */
    public function next(?string $deviceId = null): mixed
    {
        return $this->client->post('me/player/next', ['device_id' => $deviceId]);
    }

    /**
     * Skips to previous track in the user’s queue.
     *
     * @scope user-modify-playback-state
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/skip-users-playback-to-previous-track
     */
    public function previous(?string $deviceId = null): mixed
    {
        return $this->client->post('me/player/previous', ['device_id' => $deviceId]);
    }

    /**
     * Seeks to the given position in the user’s currently playing track.
     *
     * @scope user-modify-playback-state
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/seek-to-position-in-currently-playing-track
     */
    public function seek(int $positionMs, ?string $deviceId = null): mixed
    {
        return $this->client->put('me/player/seek', [
            'position_ms' => $positionMs,
            'device_id' => $deviceId,
        ]);
    }

    /**
     * Set the repeat mode for the user's playback. Options are repeat-track, repeat-context, and off.
     *
     * @scope user-modify-playback-state
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/set-repeat-mode-on-users-playback
     */
    public function repeat(string $state, ?string $deviceId = null): mixed
    {
        return $this->client->put('me/player/repeat', [
            'state' => $state,
            'device_id' => $deviceId,
        ]);
    }

    /**
     * Set the volume for the user’s current playback device.
     *
     * @scope user-modify-playback-state
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/set-volume-for-users-playback
     */
    public function volume(int $volumePercent, ?string $deviceId = null): mixed
    {
        return $this->client->put('me/player/volume', [
            'volume_percent' => $volumePercent,
            'device_id' => $deviceId,
        ]);
    }

    /**
     * Toggle shuffle on or off for user’s playback.
     *
     * @scope user-modify-playback-state
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/toggle-shuffle-for-users-playback
     */
    public function shuffle(bool $state, ?string $deviceId = null): mixed
    {
        return $this->client->put('me/player/shuffle', [
            'state' => $state,
            'device_id' => $deviceId,
        ]);
    }

    /**
     * Get tracks from the current user's recently played tracks.
     * Note: Currently doesn't support podcast episodes.
     *
     * @scope user-read-recently-played
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-recently-played
     *
     * @param  array<string, string|integer>  $payload
     */
    public function recentlyPlayedTracks(array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'me/player/recently-played',
            mappingClass: PlayHistory::class,
            client: $this->client,
            payload: $payload,
        );
    }

    /**
     * Get the list of objects that make up the user's queue.
     *
     * @scope user-read-playback-state
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/toggle-shuffle-for-users-playback
     */
    public function queue(): mixed
    {
        return new PlayerSingleObject($this->client->get('me/player/queue'));
    }

    /**
     * Add an item to the end of the user's current playback queue.
     *
     * @scope user-modify-playback-state
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/add-to-queue
     */
    public function addToQueue(string $uri, ?string $deviceId = null): mixed
    {
        return $this->client->post('me/player/queue', [
            'uri' => $uri,
            'device_id' => $deviceId,
        ]);
    }
}
