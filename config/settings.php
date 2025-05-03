<?php

declare(strict_types=1);

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
