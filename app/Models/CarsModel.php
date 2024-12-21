<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function brand(): BelongsTo
    {
        return $this->belongsTo(CarBrand::class, 'brand_id', 'id');
    }
}
