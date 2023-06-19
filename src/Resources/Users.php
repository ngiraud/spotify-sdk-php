<?php

namespace Spotify\Resources;

use Spotify\Exceptions\ResourceNotFoundException;
use Spotify\SingleObjects\Artist;
use Spotify\SingleObjects\Track;
use Spotify\SingleObjects\User;
use Spotify\Support\PaginatedResults;

class Users extends SpotifyResource
{
    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-current-users-profile
     */
    public function me(): User
    {
        return new User($this->client->get('me'));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-profile
     */
    public function profile(?string $id = null): User
    {
        if (is_null($id)) {
            return $this->me();
        }

        return new User($this->client->get("users/{$id}"));
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-top-artists-and-tracks
     *
     * @throws ResourceNotFoundException
     */
    public function topArtists(array $payload = []): PaginatedResults
    {
        return $this->topItems('artists', $payload);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-top-artists-and-tracks
     *
     * @throws ResourceNotFoundException
     */
    public function topTracks(array $payload = []): PaginatedResults
    {
        return $this->topItems('tracks', $payload);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-top-artists-and-tracks
     *
     * @return PaginatedResults<Artist|Track>
     *
     * @throws ResourceNotFoundException
     */
    public function topItems(string $type, array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: "me/top/{$type}",
            mappingClass: match ($type) {
                'artists' => Artist::class,
                'tracks' => Track::class,
                default => throw new ResourceNotFoundException()
            },
            client: $this->client,
            payload: $payload,
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/follow-playlist
     */
    public function followPlaylist(string $id, bool $public = true): mixed
    {
        return $this->client->put("playlists/{$id}/followers", ['public' => $public]);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/unfollow-playlist
     */
    public function unfollowPlaylist(string $id): mixed
    {
        return $this->client->delete("playlists/{$id}/followers");
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/check-if-user-follows-playlist
     */
    public function followingPlaylist(string $id, string|array $ids): mixed
    {
        return $this->client->get(
            sprintf("playlists/{$id}/followers/contains?ids=%s", implode(',', (array) $ids))
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/get-followed
     */
    public function followedArtists(string $type = 'artist', array $payload = []): PaginatedResults
    {
        return PaginatedResults::make(
            endpoint: 'me/following',
            mappingClass: Artist::class,
            client: $this->client,
            payload: ['type' => $type, ...$payload],
            entryKey: 'artists',
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/follow-artists-users
     */
    public function followArtists(string|array $ids): mixed
    {
        return $this->followArtistsOrUsers('artist', $ids);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/follow-artists-users
     */
    public function followUsers(string|array $ids): mixed
    {
        return $this->followArtistsOrUsers('user', $ids);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/follow-artists-users
     */
    public function followArtistsOrUsers(string $type, string|array $ids): mixed
    {
        return $this->client->put(
            sprintf('me/following?type=%s&ids=%s', $type, implode(',', (array) $ids))
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/unfollow-artists-users
     */
    public function unfollowArtists(string|array $ids): mixed
    {
        return $this->unfollowArtistsOrUsers('artist', $ids);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/unfollow-artists-users
     */
    public function unfollowUsers(string|array $ids): mixed
    {
        return $this->unfollowArtistsOrUsers('user', $ids);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/unfollow-artists-users
     */
    public function unfollowArtistsOrUsers(string $type, string|array $ids): mixed
    {
        return $this->client->delete(
            sprintf('me/following?type=%s&ids=%s', $type, implode(',', (array) $ids))
        );
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/check-current-user-follows
     */
    public function followingArtists(string|array $ids): mixed
    {
        return $this->followingArtistsOrUsers('artist', $ids);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/check-current-user-follows
     */
    public function followingUsers(string|array $ids): mixed
    {
        return $this->followingArtistsOrUsers('user', $ids);
    }

    /**
     * @see https://developer.spotify.com/documentation/web-api/reference/check-current-user-follows
     */
    public function followingArtistsOrUsers(string $type, string|array $ids): mixed
    {
        return $this->client->get(
            sprintf('me/following/contains?type=%s&ids=%s', $type, implode(',', (array) $ids))
        );
    }
}
