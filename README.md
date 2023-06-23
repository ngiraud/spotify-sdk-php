# SDK for using Spotify in PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ngiraud/spotify-sdk-php.svg?style=flat-square)](https://packagist.org/packages/ngiraud/spotify-sdk-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/ngiraud/spotify-sdk-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ngiraud/spotify-sdk-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/ngiraud/spotify-sdk-php.svg?style=flat-square)](https://packagist.org/packages/ngiraud/spotify-sdk-php)

This package contains the PHP SDK to work with the [Spotify Wep API](https://developer.spotify.com/documentation/web-api).

## Table of Contents

- [Get Started](#get-started)
- [Usage](#usage)
    - [Models Resource](#models-resource)
    - [Completions Resource](#completions-resource)
    - [Chat Resource](#chat-resource)
    - [Audio Resource](#audio-resource)
    - [Edits Resource](#edits-resource)
    - [Embeddings Resource](#embeddings-resource)
    - [Files Resource](#files-resource)
    - [FineTunes Resource](#finetunes-resource)
    - [Moderations Resource](#moderations-resource)
    - [Images Resource](#images-resource)
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
$client = new Spotify\Client('<access-token>');

$album = $client->albums()->find('<spotify-album-id>', ['market' => 'FR']);
```

## Usage

### `Albums` Resource

#### `find`

Get Spotify catalog information for a single or multiple albums.

```php
// Returns an instance of Spotify\SingleObjects\Album
$album = $client->albums()->find('<spotify-album-id>');

echo $album->name;
```

#### `findMultiple`

Get Spotify catalog information for multiple albums identified by their Spotify IDs.

```php
// Returns an instance of Spotify\Support\PaginatedResults
$album = $client->albums()->findMultiple(['<spotify-album-id-1>', '<spotify-album-id-2>']);

echo $album->results();
```

#### `tracks`

Get Spotify catalog information about an album’s tracks.

```php
// Returns an instance of Spotify\Support\PaginatedResults
$album = $client->albums()->findMultiple(['<spotify-album-id-1>', '<spotify-album-id-2>']);

echo $album->results();
```

## TODO

- Add tests
- Present all the endpoints in the README.

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
