<?php

namespace App\Actions\Cars;


use App\Models\CarsModel;
use Illuminate\Database\Eloquent\Collection;

class FindCar
{
    public function execute(string $term): Collection
    {
        return CarsModel::query()
            ->with(['brand'])
            ->whereRaw('model ILIKE ?', ["%{$term}%"])
            ->get();
    }
}
