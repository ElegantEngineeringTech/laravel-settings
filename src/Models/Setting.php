<?php

declare(strict_types=1);

namespace Elegantly\Settings\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $name
 * @property mixed $value
 * @property string $namespace
 * @property array<mixed> $metadata
 * @property ?int $model_id
 * @property ?string $model_type
 * @property-read ?Model $model
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class Setting extends Model
{
    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    protected $attributes = [
        'metadata' => '{}',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'json',
            'metadata' => 'array',
        ];
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
