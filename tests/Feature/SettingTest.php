<?php

declare(strict_types=1);

use Elegantly\Settings\Models\Setting;

it('casts value to a bool', function () {
    $setting = Setting::create([
        'namespace' => 'namespace',
        'name' => 'boolean',
        'value' => true,
    ]);

    expect($setting->value)->toBe(true);
});

it('casts value to a string', function () {
    $setting = Setting::create([
        'namespace' => 'namespace',
        'name' => 'boolean',
        'value' => 'a string',
    ]);

    expect($setting->value)->toBe('a string');
});

it('casts value to an array', function () {
    $setting = Setting::create([
        'namespace' => 'namespace',
        'name' => 'array',
        'value' => [
            'foo' => 'bar',
        ],
    ]);

    expect($setting->value)->toBe([
        'foo' => 'bar',
    ]);
});
