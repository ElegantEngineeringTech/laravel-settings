<?php

declare(strict_types=1);

namespace Elegantly\Settings;

use Elegantly\Settings\Models\Setting;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SettingsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-settings')
            ->hasConfigFile()
            ->hasMigration('create_settings_table');
    }

    public function registeringPackage(): void
    {
        $this->app->scoped(Settings::class, function () {
            return new Settings(
                // @phpstan-ignore-next-line
                model: config('settings.model') ?? Setting::class,
                // @phpstan-ignore-next-line
                cacheEnabled: config('settings.cache.enabled') ?? true,
                // @phpstan-ignore-next-line
                cacheKey: config('settings.cache.key') ?? 'settings',
                // @phpstan-ignore-next-line
                cacheTtl: config('settings.cache.ttl') ?? 86_400
            );
        });
    }
}
