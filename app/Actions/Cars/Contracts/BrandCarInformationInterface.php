<?php

namespace App\Actions\Cars\Contracts;

use App\Dto\Cars\BrandInformationDto;

interface BrandCarInformationInterface
{
    /**
     * @return BrandInformationDto[]
     */
    public function getBrands(): array;
}
