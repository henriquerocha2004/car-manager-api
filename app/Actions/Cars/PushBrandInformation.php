<?php

namespace App\Actions\Cars;

use App\Actions\Cars\Contracts\BrandCarInformationInterface;
use App\Models\CarBrand;
use Illuminate\Support\Facades\Log;

readonly class PushBrandInformation
{
    public function __construct(
        private BrandCarInformationInterface $brandCarInformation
    ) {
    }

    public function execute(): void
    {
        $brands = $this->brandCarInformation->getBrands();

        if (count($brands) < 1) {
            Log::info('NO_BRANDS_FOUND');
            return;
        }

        foreach ($brands as $brand) {
            CarBrand::query()->updateOrCreate(
                ['brand' => $brand->brand],
                [
                    'fipe_code' => $brand->fipeCode,
                    'url_logo' => $brand->urlLogo,
                ]
            );
        }
    }
}
