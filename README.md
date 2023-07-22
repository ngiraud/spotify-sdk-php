# SDK for using Spotify in PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ngiraud/spotify-sdk-php.svg?style=flat-square)](https://packagist.org/packages/ngiraud/spotify-sdk-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/ngiraud/spotify-sdk-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ngiraud/spotify-sdk-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/ngiraud/spotify-sdk-php.svg?style=flat-square)](https://packagist.org/packages/ngiraud/spotify-sdk-php)

This package contains the PHP SDK to work with the [Spotify Web API](https://developer.spotify.com/documentation/web-api).

## Table of Contents

- [Get Started](#get-started)
- [Usage](#usage)
    - [Handling Pagination](#handling-pagination)
    - [Albums Resource](#albums-resource)
    - [Artists Resource](#artists-resource)
    - [Audiobooks Resource](#audiobooks-resource)
    - [Categories Resource](#categories-resource)
    - [Chapters Resource](#chapters-resource)
    - [Episodes Resource](#episodes-resource)
    - [Genres Resource](#genres-resource)
    - [Markets Resource](#markets-resource)
    - [Player Resource](#player-resource)
    - [Playlists Resource](#playlists-resource)
    - [Search Resource](#search-resource)
    - [Shows Resource](#shows-resource)
    - [Tracks Resource](#tracks-resource)
    - [Users Resource](#users-resource)
- [TODO](#todo)
- [Testing](#testing)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Security Vulnerabilities](#security-vulnerabilities)
- [Credits](#credits)
- [License](#license)

## Get Started

> **Requires [PHP 8.1+](https://php.net/releases/)**

First, install the client via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require ngiraud/spotify-sdk-php
```

You must also install Guzzle if your project does not already have a it integrated:

```bash
composer require guzzlehttp/guzzle
```

In order to use the SDK, you need to request an access_token. You can get an example from
the [Spotify Web API docs](https://developer.spotify.com/documentation/web-api/tutorials/code-flow).

If you use Laravel, you can use [Socialite](https://laravel.com/docs/10.x/socialite) and the adapter provided by the community
on [their website](https://socialiteproviders.com/Spotify/).

Below is an example on how to authenticate with Laravel Socialite.

```php
Route::get('/spotify/redirect', function () {
    return Socialite::driver('spotify')
                    ->scopes([
                    // the list of scopes you want to allow
                    ])
                    ->redirect();
});

Route::get('/spotify/callback', function () {
    $user = Socialite::driver('spotify')->user();

    return $user->token;
});
```

You can now interact with Spotify's API:

```php
use Spotify\Spotify;

$client = Spotify::client('<access-token>');

$album = $client->albums()->find('<spotify-album-id>', ['market' => 'FR']);
```

You can also use the [Client Credentials flow](https://developer.spotify.com/documentation/web-api/tutorials/client-credentials-flow) to authenticate:

```php
use Spotify\Spotify;

$client = Spotify::basic('<client-id>', '<client-secret>');

$seeds = $client->genres()->seeds();
```

Please keep in mind that only endpoints that do not access user information can be accessed using this particular authentication flow.

## Usage

### Handling Pagination

On some resources, some methods such as `findMultiple` will return an instance of `Spotify\Support\PaginatedResults`.
This instance returns a list of records, and can handle other things like fetch the next or previous page of results.

#### Available methods

- `results()`
- `links()`
- `previousUrl()`
- `nextUrl()`
- `previous()`
- `next()`
- `meta()`
- `total()`

### `Albums` Resource

You can access the Albums resource via the `albums` method from the client.

#### Available methods:

- `find()`
- `findMultiple()`
- `tracks()`
- `findSaved()`
- `save()`
- `deleteSaved()`
- `checkSaved()`
- `newReleases()`

#### Example

```php
// Returns an instance of Spotify\SingleObjects\Album
$album = $client->albums()->find('<spotify-album-id>');
echo $album->name;

// Returns an instance of Spotify\Support\PaginatedResults
$tracks = $client->albums()->tracks('<spotify-album-id>', ['market' => 'FR', 'limit' => 5]);
echo $tracks->results();
```

### `Artists` Resource

You can access the Artists resource via the `artists` method from the client.

#### Available methods:

- `find()`
- `findMultiple()`
- `albums()`
- `topTracks()`
- `relatedArtists()`

#### Example

```php
// Returns an instance of Spotify\SingleObjects\Artist
$artist = $client->artists()->find('<spotify-artist-id>');
echo $artist->name;

// Returns an instance of Spotify\Support\PaginatedResults
$albums = $client->artists()->albums('<spotify-artist-id>', ['market' => 'FR', 'limit' => 5]);
echo $albums->results();
```

### `Audiobooks` Resource

> **Note: Audiobooks are only available for the US, UK, Ireland, New Zealand and Australia markets.**

You can access the Audiobooks resource via the `audiobooks` method from the client.

#### Available methods:

- `find()`
- `findMultiple()`
- `chapters()`
- `findSaved()`
- `save()`
- `deleteSaved()`
- `checkSaved()`

#### Example

```php
// Returns an instance of Spotify\SingleObjects\Audiobook
$audiobook = $client->audiobooks()->find('<spotify-audiobook-id>');
echo $audiobook->name;

// Returns an instance of Spotify\Support\PaginatedResults
$chapters = $client->audiobooks()->chapters('<spotify-audiobook-id>', ['limit' => 5]);
echo $chapters->results();
```

### `Categories` Resource

You can access the Categories resource via the `categories` method from the client.

#### Available methods:

- `find()`
- `browse()`

#### Example

```php
// Returns an instance of Spotify\SingleObjects\Category
$category = $client->categories()->find('<spotify-category-id>');
echo $category->name;

// Returns an instance of Spotify\Support\PaginatedResults
$categories = $client->categories()->browse();
echo $categories->results();
```

### `Chapters` Resource

You can access the Chapters resource via the `chapters` method from the client.

#### Available methods:

- `find()`
- `findMultiple()`

#### Example

```php
// Returns an instance of Spotify\SingleObjects\Category
$chapter = $client->chapters()->find('<spotify-chapter-id>');
echo $chapter->name;

// Returns an instance of Spotify\Support\PaginatedResults
$chapters = $client->chapters()->browse();
echo $chapters->results();
```

### `Episodes` Resource

You can access the Episodes resource via the `episodes` method from the client.

#### Available methods:

- `find()`
- `findMultiple()`
- `findSaved()`
- `save()`
- `deleteSaved()`
- `checkSaved()`

#### Example

```php
// Returns an instance of Spotify\SingleObjects\Episode
$episode = $client->episodes()->find('<spotify-episode-id>');
echo $episode->name;

// Returns an array with the status for each episode
$episodes = $client->episodes()->checkSaved(['<spotify-episode-id>', '<spotify-episode-id>']);
echo $episodes;
```

### `Genres` Resource

You can access the Genres resource via the `genres` method from the client.

#### Available methods:

- `seeds()`

#### Example

```php
// Returns an array of genres
$seeds = $client->genres()->seeds();
echo $seeds;
```

### `Markets` Resource

You can access the Markets resource via the `markets` method from the client.

#### Available methods:

- `all()`

#### Example

```php
// Returns an array of markets
$markets = $client->markets()->all();
echo $markets;
```

### `Player` Resource

You can access the Player resource via the `player` method from the client.

#### Available methods:

- `state()`
- `transfer()`
- `availableDevices()`
- `currentlyPlayingTrack()`
- `start()`
- `pause()`
- `next()`
- `previous()`
- `seek()`
- `repeat()`
- `volume()`
- `shuffle()`
- `recentlyPlayedTracks()`
- `queue()`
- `addToQueue()`

#### Example

```php
// Returns an instance of Spotify\SingleObjects\Player
$player = $client->player()->state();
echo $player->is_playing;
```

### `Playlists` Resource

You can access the Playlists resource via the `playlists` method from the client.

#### Available methods:

- `find()`
- `forCurrentUser()`
- `forUser()`
- `create()`
- `update()`
- `tracks()`
- `reorderTracks()`
- `replaceTracks()`
- `addTracks()`
- `deleteTracks()`
- `featured()`
- `forCategory()`
- `coverImage()`
- `addCoverImage()`

#### Example

```php
// Returns an instance of Spotify\SingleObjects\Playlist
$playlist = $client->playlists()->find('<spotify-playlist-id>');
echo $playlist->name;

// Returns an instance of Spotify\Support\PaginatedResults
$playlists = $client->playlists()->forCategory('<spotify-category-id>');
echo $playlists->results();
```

### `Search` Resource

You can access the Search resource via the `search` method from the client.
The search method will return an instance of `Spotify\SingleObjects\Search`, and every type of results is accessible via its own method.
This end method will return an instance of `Spotify\Support\PaginatedResults`.

#### Available methods after the search

- `audiobooks()`
- `albums()`
- `artists()`
- `episodes()`
- `playlists()`
- `shows()`
- `tracks()`

#### Example

```php
// Returns an instance of Spotify\SingleObjects\Search
$results = $client->search('alice cooper', 'artist');

// $results->artists() is an instance of Spotify\Support\PaginatedResults
// $artist is an instance of Spotify\SingleObjects\Artist
foreach ($results->artists() as $artist) {
    echo $artist->name;
}
```

### `Shows` Resource

You can access the Shows resource via the `shows` method from the client.

#### Available methods:

- `find()`
- `findMultiple()`
- `episodes()`
- `findSaved()`
- `save()`
- `deleteSaved()`
- `checkSaved()`

#### Example

```php
// Returns an instance of Spotify\SingleObjects\Show
$show = $client->shows()->find('<spotify-show-id>');
echo $show->name;

// Returns an instance of Spotify\Support\PaginatedResults
$episodes = $client->shows()->episodes('<spotify-show-id>');
echo $episodes->results();
```

### `Tracks` Resource

You can access the Tracks resource via the `tracks` method from the client.

#### Available methods:

- `find()`
- `findMultiple()`
- `findSaved()`
- `save()`
- `deleteSaved()`
- `checkSaved()`
- `audioFeatures()`
- `audioAnalysis()`
- `recommendations()`

#### Example

```php
// Returns an instance of Spotify\SingleObjects\Track
$track = $client->tracks()->find('<spotify-track-id>');
echo $track->name;

// Returns an instance of Spotify\Support\PaginatedResults
$recommendedTracks = $client->tracks()->recommendations();
echo $recommendedTracks->results();
```

### `Users` Resource

You can access the Users resource via the `users` method from the client.

#### Available methods:

- `me()`
- `profile()`
- `topArtists()`
- `topTracks()`
- `topItems()`
- `followPlaylist()`
- `unfollowPlaylist()`
- `followingPlaylist()`
- `followedArtists()`
- `followArtists()`
- `followUsers()`
- `followArtistsOrUsers()`
- `unfollowArtists()`
- `unfollowUsers()`
- `unfollowArtistsOrUsers()`
- `followingArtists()`
- `followingUsers()`
- `followingArtistsOrUsers()`

#### Example

```php
// Returns an instance of Spotify\SingleObjects\User
$me = $client->users()->me();
echo $me->display_name;
```

## TODO

Tests are being written. Currently missing tests for:

- Player
- Search
- Shows
- Tracks
- Users
- PaginatedResults

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover any security related issues, please email [contact@ngiraud.me](mailto:contact@ngiraud.me) instead of using the issue tracker.

## Credits

- [Nicolas Giraud](https://github.com/ngiraud)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
