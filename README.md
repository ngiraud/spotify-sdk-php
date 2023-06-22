# SDK for using Spotify in PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ngiraud/spotify-sdk-php.svg?style=flat-square)](https://packagist.org/packages/ngiraud/spotify-sdk-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/ngiraud/spotify-sdk-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ngiraud/spotify-sdk-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/ngiraud/spotify-sdk-php.svg?style=flat-square)](https://packagist.org/packages/ngiraud/spotify-sdk-php)

This package contains the PHP SDK to work with the [Spotify Wep API](https://developer.spotify.com/documentation/web-api).

## Installation

You can install the package via composer:

```bash
composer require ngiraud/spotify-sdk-php
```

You must also install Guzzle:

```bash
composer require guzzlehttp/guzzle
```

In order to use the SDK, you need to request an access_token. You can get an example from
the [Spotify Web API docs](https://developer.spotify.com/documentation/web-api/tutorials/code-flow).

If you use Laravel, you can use [Socialite](https://laravel.com/docs/10.x/socialite) and the adapter provided by the community
on [their website](https://socialiteproviders.com/Spotify/).

Here is an example:

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

## Usage

To get started, you must first new up an instance of `Spotify\Client`.

```php
$client = new Spotify\Client('<access-token>');
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
