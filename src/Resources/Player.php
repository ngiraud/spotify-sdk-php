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
     * @see https://developer.spotify.com/documentation/web-api/reference/get-information-about-the-users-current-playback
     */
    public function state(array $payload = []): mixed
    {
        return new PlayerSingleObject($this->client->get('me/player', $payload));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/transfer-a-users-playback
     */
    public function transferPlayback(array $deviceIds, bool $play = false): mixed
    {
        return $this->client->put('me/player', [
            'device_ids' => $deviceIds,
            'play' => $play,
        ]);
    }

    /**
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
     * @see https://developer.spotify.com/documentation/web-api/reference/get-the-users-currently-playing-track
     */
    public function currentlyPlayingTrack(array $payload = []): mixed
    {
        return new PlayerSingleObject($this->client->get('me/player/currently-playing', $payload));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/start-a-users-playback
     */
    public function start(?string $deviceId = null): mixed
    {
        return $this->client->put('me/player/play', ['device_id' => $deviceId]);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/pause-a-users-playback
     */
    public function pause(?string $deviceId = null): mixed
    {
        return $this->client->put('me/player/pause', ['device_id' => $deviceId]);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/skip-users-playback-to-next-track
     */
    public function next(?string $deviceId = null): mixed
    {
        return $this->client->post('me/player/next', ['device_id' => $deviceId]);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/skip-users-playback-to-previous-track
     */
    public function previous(?string $deviceId = null): mixed
    {
        return $this->client->post('me/player/previous', ['device_id' => $deviceId]);
    }

    /**
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
     * @see https://developer.spotify.com/documentation/web-api/reference/get-recently-played
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
     * @see https://developer.spotify.com/documentation/web-api/reference/toggle-shuffle-for-users-playback
     */
    public function queue(): mixed
    {
        return new PlayerSingleObject($this->client->get('me/player/queue'));
    }

    /**
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
