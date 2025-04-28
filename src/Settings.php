<?php

declare(strict_types=1);

namespace Elegantly\Settings;

use Elegantly\Settings\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class Settings
{
    /**
     * @var ?array<string, Collection<int, Setting>>
     */
    public ?array $settings = null;

    /**
     * @param  class-string<Setting>  $model
     */
    public function __construct(
        public string $model,
        public bool $cacheEnabled,
        public string $cacheKey,
        public int $cacheTtl,
    ) {}

    /**
     * @return ?array<string, Collection<int, Setting>>
     */
    public function getCachedSettings(): ?array
    {
        if ($this->cacheEnabled) {
            // @phpstan-ignore-next-line
            return Cache::get($this->cacheKey);
        }

        return null;
    }

    /**
     * @param  array<string, Collection<int, Setting>>  $value
     */
    public function setCachedSettings(array $value): static
    {
        if ($this->cacheEnabled) {
            Cache::put($this->cacheKey, $value, $this->cacheTtl);
        }

        return $this;
    }

    public function forgetCachedSettings(): static
    {
        if ($this->cacheEnabled) {
            Cache::forget($this->cacheKey);
        }

        return $this;
    }

    public function load(): static
    {

        if ($cached = $this->getCachedSettings()) {

            $this->settings = $cached;

        } else {

            $settings = $this->model::query()
                ->where('model_type', null)
                ->where('model_id', null)
                ->get()
                ->groupBy('namespace')
                ->all();

            $this->setCachedSettings($settings);

            $this->settings = $settings;

        }

        return $this;
    }

    public function get(
        string $namespace,
        string $name,
        mixed $default = null
    ): ?Setting {
        return $this->only($namespace)->firstWhere('name', $name) ?? $default;
    }

    /**
     * @param  array<mixed>  $metadata
     */
    public function set(
        string $namespace,
        string $name,
        mixed $value,
        array $metadata = [],
    ): Setting {

        if ($this->settings === null) {
            return $this->load()->set($namespace, $name, $value);
        }

        $setting = $this->get($namespace, $name);

        if ($setting) {
            $setting->value = $value;
            $setting->metadata = array_merge_recursive($setting->metadata, $metadata);
            $setting->save();
        } else {
            $setting = $this->makeSetting();
            $setting->name = $name;
            $setting->namespace = $namespace;
            $setting->value = $value;
            $setting->metadata = $metadata;
            $setting->save();

            $this->settings[$namespace] ??= new Collection;

            $this->settings[$namespace]->push($setting);
        }

        $this->setCachedSettings($this->settings);

        return $setting;
    }

    /**
     * @return array<string, Collection<int, Setting>>
     */
    public function all(): array
    {
        if ($this->settings === null) {
            $this->load();
        }

        return $this->settings ?? [];
    }

    /**
     * @return Collection<int, Setting>
     */
    public function only(string $namespace): Collection
    {
        return $this->all()[$namespace] ?? new Collection;
    }

    public function forget(): static
    {
        $this->settings = [];

        $this->forgetCachedSettings();

        return $this;
    }

    public function makeSetting(): Setting
    {
        return new $this->model;
    }
}
