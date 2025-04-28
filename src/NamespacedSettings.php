<?php

declare(strict_types=1);

namespace Elegantly\Settings;

use Elegantly\Settings\Facades\Settings;
use Elegantly\Settings\Models\Setting;
use Illuminate\Database\Eloquent\Collection;

abstract class NamespacedSettings
{
    final public function __construct()
    {
        $this->load();
    }

    public static function get(): static
    {
        return static::make();
    }

    abstract public static function getNamespace(): string;

    public function load(): static
    {
        return $this->fill(
            Settings::only($this->getNamespace())
        );
    }

    /**
     * @param  Collection<int, Setting>  $settings
     */
    public function fill(Collection $settings): static
    {

        $namespace = $this->getNamespace();

        foreach (get_object_vars($this) as $name => $value) {

            $setting = $settings->firstWhere(function ($setting) use ($namespace, $name) {
                return $setting->namespace === $namespace && $setting->name === $name;
            });

            if (! $setting) {
                continue;
            }

            $this->{$name} = $setting->value;

        }

        return $this;
    }

    public function save(): static
    {

        $namespace = $this->getNamespace();

        foreach (get_object_vars($this) as $name => $value) {

            Settings::set(
                $namespace,
                $name,
                $value
            );

        }

        $this->load();

        return $this;

    }
}
