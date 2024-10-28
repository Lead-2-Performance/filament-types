<?php

namespace TomatoPHP\FilamentTypes\Models;

use GeneaLabs\LaravelModelCaching\CachedModel;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

/**
 * @property int $id
 * @property int $type_id
 * @property int $model_id
 * @property string $model_type
 * @property string $key
 * @property mixed $value
 * @property string $created_at
 * @property string $updated_at
 * @property Type $type
 */
class TypesMeta extends CachedModel
{
    use Cachable;

    protected $cachePrefix = 'tomato_types_meta_';

    /**
     * @var array
     */
    protected $fillable = ['type_id', 'model_id', 'model_type', 'key', 'value', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        $model = config('filament-types.model') ?? \TomatoPHP\FilamentTypes\Models\Type::class;
        return $this->belongsTo($model);
    }
}
