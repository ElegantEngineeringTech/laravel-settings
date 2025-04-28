<?php

declare(strict_types=1);

use Elegantly\Settings\Facades\Settings;
use Illuminate\Support\Facades\Cache;

it('sets a setting value', function () {
    $setting = Settings::set(
        namespace: 'default',
        name: 'array',
        value: [
            'foo' => 'bar',
        ],
    );

    expect($setting->value)->toBe([
        'foo' => 'bar',
    ]);
});

it('gets a setting value', function () {
    Settings::set(
        namespace: 'default',
        name: 'array',
        value: [
            'foo' => 'bar',
        ],
    );

    $setting = Settings::get(
        namespace: 'default',
        name: 'array',
    );

    expect($setting->value)->toBe([
        'foo' => 'bar',
    ]);
});

it('loads settings from class', function () {
    Cache::spy();

    Settings::set(
        namespace: 'default',
        name: 'bool',
        value: true,
    );

    Settings::set(
        namespace: 'default',
        name: 'string',
        value: 'bar',
    );

    Settings::get(
        namespace: 'default',
        name: 'bool',
    );

    Settings::get(
        namespace: 'default',
        name: 'string',
    );

    $settings = Settings::all();

    expect($settings['default'])->toHaveLength(2);

    Cache::shouldHaveReceived('get')
        ->once()
        ->with('settings');

    Cache::shouldHaveReceived('put')
        ->times(3); // load, set, set

});
