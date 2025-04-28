<?php

declare(strict_types=1);

namespace Elegantly\Settings;

use Elegantly\Settings\Facades\Settings;
use Elegantly\Settings\Models\Setting;
use Illuminate\Database\Eloquent\Collection;

abstract class NamespacedSettings
{
    abstract public function getNamespace(): string;

    /**
     * @var Collection<int, Setting>
     */
    protected Collection $settings;

    public function __construct()
    {
        $this->load();
    }

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

        $this->settings = new Collection;

        $namespace = $this->getNamespace();

        foreach (get_object_vars($this) as $name => $value) {
            if (in_array($name, ['settings'])) {
                continue;
            }

            $setting = $settings->firstWhere(function ($setting) use ($namespace, $name) {
                return $setting->namespace === $namespace && $setting->name === $name;
            });

            if (! $setting) {
                continue;
            }

            $this->{$name} = $setting->value;

            $this->settings->push($setting);

        }

        return $this;
    }

    public function save(): static
    {

        $namespace = $this->getNamespace();

        foreach (get_object_vars($this) as $name => $value) {
            if (in_array($name, ['settings'])) {
                continue;
            }

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
