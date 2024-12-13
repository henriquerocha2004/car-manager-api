<?php

namespace App\Actions\Cars;

use App\Actions\Cars\Contracts\CarInformationInterface;
use App\Models\CarBrand;
use App\Models\CarsModel;
use Illuminate\Support\Facades\Log;

readonly class PushCarsInformation
{
    public function __construct(
        private CarInformationInterface $carInformation
    ) {
    }

    public function execute(): void
    {
        $brands = CarBrand::query()->select('fipe_code', 'id')->orderBy('fipe_code')->get();

        if ($brands->isEmpty()) {
            Log::info('BRANDS_NOT_FOUND_IN_DATABASE');
            return;
        }

        /** @var CarBrand $brand */
        foreach ($brands as $brand) {
            $params = ['fipe_code' => $brand->fipe_code];

            $cars =  $this->carInformation->getCars($params);

            if (empty($cars)) {
                continue;
            }

            foreach ($cars as $car) {
                CarsModel::query()->updateOrCreate(
                    ['fipe_lib_model_code' => $car->fipeLibModelCode],
                    [
                         'model' => $car->model,
                         'year' => $car->year,
                         'fuel_type' => $car->fuel,
                         'brand_id' => $brand->id,
                         'fipe_code' => $car->fipeCode,
                     ]
                );
            }
        }
    }
}
