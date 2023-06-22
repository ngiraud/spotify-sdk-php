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
     * Get detailed profile information about the current user (including the current user's username).
     *
     * @scope user-read-private, user-read-email
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-current-users-profile
     */
    public function me(): User
    {
        return new User($this->client->get('me'));
    }

    /**
     * Get public profile information about a Spotify user.
     *
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
     * Get the current user's top artists based on calculated affinity.
     *
     * @scope user-top-read
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-top-artists-and-tracks
     *
     * @param  array<string, string|integer>  $payload
     * @return PaginatedResults<Artist>
     *
     * @throws ResourceNotFoundException
     */
    public function topArtists(array $payload = []): PaginatedResults
    {
        return $this->topItems('artists', $payload);
    }

    /**
     * Get the current user's top tracks based on calculated affinity.
     *
     * @scope user-top-read
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-top-artists-and-tracks
     *
     * @param  array<string, string|integer>  $payload
     * @return PaginatedResults<Track>
     *
     * @throws ResourceNotFoundException
     */
    public function topTracks(array $payload = []): PaginatedResults
    {
        return $this->topItems('tracks', $payload);
    }

    /**
     * Get the current user's top artists or tracks based on calculated affinity.
     *
     * @scope user-top-read
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-users-top-artists-and-tracks
     *
     * @param  array<string, string|integer>  $payload
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
     * Add the current user as a follower of a playlist.
     *
     * @scope playlist-modify-public, playlist-modify-private
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/follow-playlist
     */
    public function followPlaylist(string $id, bool $public = true): mixed
    {
        return $this->client->put("playlists/{$id}/followers", ['public' => $public]);
    }

    /**
     * Remove the current user as a follower of a playlist.
     *
     * @scope playlist-modify-public, playlist-modify-private
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/unfollow-playlist
     */
    public function unfollowPlaylist(string $id): mixed
    {
        return $this->client->delete("playlists/{$id}/followers");
    }

    /**
     * Check to see if one or more Spotify users are following a specified playlist.
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/check-if-user-follows-playlist
     *
     * @param  array<string>  $ids
     */
    public function followingPlaylist(string $id, string|array $ids): mixed
    {
        return $this->client->get(
            sprintf("playlists/{$id}/followers/contains?ids=%s", implode(',', (array) $ids))
        );
    }

    /**
     * Get the current user's followed artists.
     *
     * @scope user-follow-read
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/get-followed
     *
     * @param  array<string, string|integer>  $payload
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
     * Add the current user as a follower of one or more artists.
     *
     * @scope user-follow-modify
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/follow-artists-users
     *
     * @param  array<string>  $ids
     */
    public function followArtists(string|array $ids): mixed
    {
        return $this->followArtistsOrUsers('artist', $ids);
    }

    /**
     * Add the current user as a follower of one or more other Spotify users.
     *
     * @scope user-follow-modify
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/follow-artists-users
     *
     * @param  array<string>  $ids
     */
    public function followUsers(string|array $ids): mixed
    {
        return $this->followArtistsOrUsers('user', $ids);
    }

    /**
     * Add the current user as a follower of one or more artists or other Spotify users.
     *
     * @scope user-follow-modify
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/follow-artists-users
     *
     * @param  array<string>  $ids
     */
    public function followArtistsOrUsers(string $type, string|array $ids): mixed
    {
        return $this->client->put(
            sprintf('me/following?type=%s&ids=%s', $type, implode(',', (array) $ids))
        );
    }

    /**
     * Remove the current user as a follower of one or more artists.
     *
     * @scope user-follow-modify
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/unfollow-artists-users
     *
     * @param  array<string>  $ids
     */
    public function unfollowArtists(string|array $ids): mixed
    {
        return $this->unfollowArtistsOrUsers('artist', $ids);
    }

    /**
     * Remove the current user as a follower of one or more other Spotify users.
     *
     * @scope user-follow-modify
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/unfollow-artists-users
     *
     * @param  array<string>  $ids
     */
    public function unfollowUsers(string|array $ids): mixed
    {
        return $this->unfollowArtistsOrUsers('user', $ids);
    }

    /**
     * Remove the current user as a follower of one or more artists or other Spotify users.
     *
     * @scope user-follow-modify
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/unfollow-artists-users
     *
     * @param  array<string>  $ids
     */
    public function unfollowArtistsOrUsers(string $type, string|array $ids): mixed
    {
        return $this->client->delete(
            sprintf('me/following?type=%s&ids=%s', $type, implode(',', (array) $ids))
        );
    }

    /**
     * Check to see if the current user is following one or more artists.
     *
     * @scope user-follow-read
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/check-current-user-follows
     *
     * @param  array<string>  $ids
     */
    public function followingArtists(string|array $ids): mixed
    {
        return $this->followingArtistsOrUsers('artist', $ids);
    }

    /**
     * Check to see if the current user is following one or more other Spotify users.
     *
     * @scope user-follow-read
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/check-current-user-follows
     *
     * @param  array<string>  $ids
     */
    public function followingUsers(string|array $ids): mixed
    {
        return $this->followingArtistsOrUsers('user', $ids);
    }

    /**
     * Check to see if the current user is following one or more artists or other Spotify users.
     *
     * @scope user-follow-read
     *
     * @see https://developer.spotify.com/documentation/web-api/reference/check-current-user-follows
     *
     * @param  array<string>  $ids
     */
    public function followingArtistsOrUsers(string $type, string|array $ids): mixed
    {
        return $this->client->get(
            sprintf('me/following/contains?type=%s&ids=%s', $type, implode(',', (array) $ids))
        );
    }
}
