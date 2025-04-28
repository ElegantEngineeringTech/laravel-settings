<?php

declare(strict_types=1);

namespace Elegantly\Settings\Commands;

use Illuminate\Console\Command;

class SettingsCommand extends Command
{
    public $signature = 'laravel-settings';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
