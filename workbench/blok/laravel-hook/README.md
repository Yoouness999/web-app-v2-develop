# Hook features for Laravel project

[![Latest Version on Packagist](https://img.shields.io/packagist/v/blok/laravel-hook.svg?style=flat-square)](https://packagist.org/packages/blok/laravel-hook)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/blok/laravel-hook/run-tests?label=tests)](https://github.com/blok/laravel-hook/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/blok/laravel-hook/Check%20&%20fix%20styling?label=code%20style)](https://github.com/blok/laravel-hook/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/blok/laravel-hook.svg?style=flat-square)](https://packagist.org/packages/blok/laravel-hook)

Add an hook features in Laravel to add, overwrite, output easily an array or css/js assets dynamically. Similar to wordpress and drupal hook features.

## Installation

You can install the package via composer:

```bash
composer require blok/laravel-hook
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-hook-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-hook-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravelHook = new Blok\LaravelHook();
echo $laravelHook->echoPhrase('Hello, Blok!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [danielsum](https://github.com/dansum)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
