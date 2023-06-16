# SDK for using Spotify in PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ngiraud/spotify-sdk-php.svg?style=flat-square)](https://packagist.org/packages/ngiraud/spotify-sdk-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/ngiraud/spotify-sdk-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ngiraud/spotify-sdk-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/ngiraud/spotify-sdk-php.svg?style=flat-square)](https://packagist.org/packages/ngiraud/spotify-sdk-php)

This is where your description should go. Try and limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/spotify-sdk-php.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/spotify-sdk-php)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us
by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address
on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require ngiraud/spotify-sdk-php
```

## Usage

```php
$skeleton = new Spotify\Client();
echo $skeleton->echoPhrase('Hello, Spotify!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Nicolas Giraud](https://github.com/ngiraud)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
