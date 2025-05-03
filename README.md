# Elegant Global Settings Management in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/elegantly/laravel-settings.svg?style=flat-square)](https://packagist.org/packages/elegantly/laravel-settings)
[![Tests](https://img.shields.io/github/actions/workflow/status/ElegantEngineeringTech/laravel-settings/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ElegantEngineeringTech/laravel-settings/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Code Style](https://img.shields.io/github/actions/workflow/status/ElegantEngineeringTech/laravel-settings/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/ElegantEngineeringTech/laravel-settings/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![PHPStan Level](https://img.shields.io/github/actions/workflow/status/ElegantEngineeringTech/laravel-settings/phpstan.yml?label=phpstan&style=flat-square)](https://github.com/ElegantEngineeringTech/laravel-settings/actions?query=workflow%3Aphpstan)
[![Laravel Pint](https://img.shields.io/github/actions/workflow/status/ElegantEngineeringTech/laravel-settings/pint.yml?label=laravel%20pint&style=flat-square)](https://github.com/ElegantEngineeringTech/laravel-settings/actions?query=workflow%3Apint)
[![Total Downloads](https://img.shields.io/packagist/dt/elegantly/laravel-settings.svg?style=flat-square)](https://packagist.org/packages/elegantly/laravel-settings)

A simple and flexible way to manage global or model-specific settings in your Laravel app.

---

## Features

-   Define global settings
-   Store settings in the database via Eloquent
-   Cache settings for performance
-   Attach settings to users or any other model
-   Support for typed namespaced settings classes

---

## Table of Contents

-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Usage](#usage)

    -   [Basic Usage (Facade)](#basic-usage-facade)
    -   [Dependency Injection](#dependency-injection)
    -   [Typed Namespaced Settings](#typed-namespaced-settings)

-   [Testing](#testing)
-   [Changelog](#changelog)
-   [Contributing](#contributing)
-   [Security](#security-vulnerabilities)
-   [Credits](#credits)
-   [License](#license)

---

## Installation

Install the package via Composer:

```bash
composer require elegantly/laravel-settings
```

Publish the migration and run it:

```bash
php artisan vendor:publish --tag="settings-migrations"
php artisan migrate
```

Optionally, publish the configuration file:

```bash
php artisan vendor:publish --tag="settings-config"
```

---

## Configuration

Published config file (`config/settings.php`):

```php
use Elegantly\Settings\Models\Setting;

return [

    /*
     * The Eloquent model used to store and retrieve settings
     */
    'model' => Setting::class,

    /*
     * Cache configuration for global settings
     */
    'cache' => [
        'enabled' => true,
        'key' => 'settings',
        'ttl' => 60 * 60 * 24, // 1 day
    ],

];
```

---

## Usage

### Basic Usage (Facade)

```php
use Elegantly\Settings\Facades\Settings;

// Set a value
Settings::set(
    namespace: 'home',
    name: 'color',
    value: 'white'
);

// Get a value
$setting = Settings::get(
    namespace: 'home',
    name: 'color'
);

$setting->value; // white
```

### Dependency Injection

```php
namespace App\Http\Controllers;

use Elegantly\Settings\Settings;

class UserController extends Controller
{
    public function index(Settings $settings)
    {
        $settings->set(
            namespace: 'home',
            name: 'color',
            value: 'white'
        );

        $setting = $settings->get(
            namespace: 'home',
            name: 'color'
        );

        $setting->value; // white
    }
}
```

### Typed Namespaced Settings

For better DX, define custom typed settings classes:

#### Usage

```php
namespace App\Http\Controllers;

use App\Settings\HomeSettings;

class UserController extends Controller
{
    public function index(HomeSettings $settings)
    {
        $settings->color; // white

        $settings->color = 'black';
        $settings->save();
    }
}
```

#### Defining a Typed Settings Class

```php
namespace App\Settings;

use Elegantly\Settings\NamespacedSettings;

class HomeSettings extends NamespacedSettings
{
    public ?string $color = null;

    /** @var int[] */
    public array $articles = [];

    public static function getNamespace(): string
    {
        return 'home';
    }
}
```

---

## Testing

Run the test suite:

```bash
composer test
```

---

## Changelog

See [CHANGELOG](CHANGELOG.md) for details on recent changes.

---

## Contributing

See [CONTRIBUTING](CONTRIBUTING.md) for contribution guidelines.

---

## Security Vulnerabilities

Please review our [security policy](../../security/policy) for reporting vulnerabilities.

---

## Credits

-   [Quentin Gabriele](https://github.com/QuentinGab)
-   [All Contributors](../../contributors)

---

## License

This package is open-sourced under the [MIT license](LICENSE.md).

---

Would you like a README badge for PHPStan or Laravel Pint added as well?
