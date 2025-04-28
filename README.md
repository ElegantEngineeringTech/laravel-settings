# Settings for your App

[![Latest Version on Packagist](https://img.shields.io/packagist/v/elegantly/laravel-settings.svg?style=flat-square)](https://packagist.org/packages/elegantly/laravel-settings)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/elegantly/laravel-settings/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ElegantEngineeringTech/laravel-settings/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/elegantly/laravel-settings/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/ElegantEngineeringTech/laravel-settings/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/elegantly/laravel-settings.svg?style=flat-square)](https://packagist.org/packages/elegantly/laravel-settings)

Settings for your Laravel App. Done right.

## Installation

You can install the package via composer:

```bash
composer require elegantly/laravel-settings
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="settings-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="settings-config"
```

This is the contents of the published config file:

```php
use Elegantly\Settings\Models\Setting;

return [

    'model' => Setting::class,

    'cache' => [
        'enabled' => true,
        'key' => 'settings',
        'ttl' => 60 * 60 * 24,
    ],

];
```

## Usage

```php
use Elegantly\Settings\Facades\Settings;

Settings::set(
    namespace: 'home',
    name: 'color',
    value: 'white'
);

$setting = Settings::get(
    namespace: 'home',
    name: 'color',
);

echo $setting->value; // white

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Quentin Gabriele](https://github.com/QuentinGab)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
