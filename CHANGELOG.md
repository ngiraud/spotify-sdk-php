# Changelog

All notable changes to `spotify-sdk-php` will be documented in this file.

## 1.0.4 - 2023-07-22

### What's Changed

- Adding tests by @ngiraud in https://github.com/ngiraud/spotify-sdk-php/pull/4
- Removing the Client::makeWithClientCredentials() method
- New way to authenticate through the Spotify class :
- - Spotify::client('access-token')
- - Spotify::basic('client-id', 'client-secret')
- 

**Full Changelog**: https://github.com/ngiraud/spotify-sdk-php/compare/1.0.3...1.0.4

## 1.0.3 - 2023-07-07

### What's Changed

- Add authentication with Client Credentials flow @ngiraud

**Full Changelog**: https://github.com/ngiraud/spotify-sdk-php/compare/1.0.2...1.0.3

## 1.0.2 - 2023-07-05

### What's Changed

- Add an exception if no access token provided by @ngiraud in https://github.com/ngiraud/spotify-sdk-php/pull/3

**Full Changelog**: https://github.com/ngiraud/spotify-sdk-php/compare/1.0.1...1.0.2

## 1.0.1 - 2023-06-24

### Update Changelog workflow

**Full Changelog**: https://github.com/ngiraud/spotify-sdk-php/compare/1.0.0...1.0.1
