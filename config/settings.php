<?php

declare(strict_types=1);

use Elegantly\Settings\Models\Setting;

return [

    'model' => Setting::class,

    'cache' => [
        'enabled' => true,
        'key' => 'settings',
        'ttl' => 60 * 60 * 24,
    ],

];
