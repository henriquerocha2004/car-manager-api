<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $brand
 * @property int $fipe_code
 * @property string|null $url_logo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|CarBrand newModelQuery()
 * @method static Builder<static>|CarBrand newQuery()
 * @method static Builder<static>|CarBrand query()
 * @method static Builder<static>|CarBrand whereBrand($value)
 * @method static Builder<static>|CarBrand whereCreatedAt($value)
 * @method static Builder<static>|CarBrand whereFipeCode($value)
 * @method static Builder<static>|CarBrand whereId($value)
 * @method static Builder<static>|CarBrand whereUpdatedAt($value)
 * @method static Builder<static>|CarBrand whereUrlLogo($value)
 * @mixin \Eloquent
 */
class CarBrand extends Model
{
    use HasFactory;

    protected $table = 'car_brands';
    protected $fillable = [
        'brand',
        'fipe_code',
        'url_logo',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function models(): HasMany
    {
        return $this->hasMany(CarsModel::class, 'brand_id', 'id');
    }
}
