<?php

declare(strict_types=1);

namespace Elegantly\Settings\Facades;

use Elegantly\Settings\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Elegantly\Settings\Settings load()
 * @method static ?Setting get(string $namespace, string $name)
 * @method static Setting set(string $namespace, string $name, mixed $value)
 * @method static array<string, Collection<int, Setting>> all()
 * @method static Collection<int, Setting> only(string $namespace)
 * @method static \Elegantly\Settings\Settings forget()
 * @method static Setting makeSetting()
 *
 * @see \Elegantly\Settings\Settings
 */
class Settings extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Elegantly\Settings\Settings::class;
    }
}
