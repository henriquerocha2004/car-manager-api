<?php

namespace App\Models;

use Database\Factories\CarsModelFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $model
 * @property string $year
 * @property string|null $fuel_type
 * @property string|null $fipe_code
 * @property string|null $fipe_lib_model_code
 * @property int $brand_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\CarBrand $brand
 * @method static CarsModelFactory factory($count = null, $state = [])
 * @method static Builder<static>|CarsModel newModelQuery()
 * @method static Builder<static>|CarsModel newQuery()
 * @method static Builder<static>|CarsModel query()
 * @method static Builder<static>|CarsModel whereBrandId($value)
 * @method static Builder<static>|CarsModel whereCreatedAt($value)
 * @method static Builder<static>|CarsModel whereFipeCode($value)
 * @method static Builder<static>|CarsModel whereFipeLibModelCode($value)
 * @method static Builder<static>|CarsModel whereFuelType($value)
 * @method static Builder<static>|CarsModel whereId($value)
 * @method static Builder<static>|CarsModel whereModel($value)
 * @method static Builder<static>|CarsModel whereUpdatedAt($value)
 * @method static Builder<static>|CarsModel whereYear($value)
 * @mixin \Eloquent
 */
class CarsModel extends Model
{
    use HasFactory;

    protected $table = 'cars_model';
    protected $fillable = [
        'model',
        'year',
        'brand_id',
        'fuel_type',
        'fipe_code',
        'fipe_lib_model_code',
    ];

    protected $hidden = [
       'created_at',
       'updated_at',
       'deleted_at',
       'brand_id'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(CarBrand::class, 'brand_id', 'id');
    }
}
