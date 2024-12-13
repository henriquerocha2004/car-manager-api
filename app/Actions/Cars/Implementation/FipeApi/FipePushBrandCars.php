<?php

namespace App\Actions\Cars\Implementation\FipeApi;

use App\Actions\Cars\Contracts\BrandCarInformationInterface;
use App\Actions\Cars\Implementation\FipeApi\FipeApiBase;
use App\Dto\Cars\BrandInformationDto;
use DeividFortuna\Fipe\FipeCarros;

class FipePushBrandCars extends FipeApiBase implements BrandCarInformationInterface
{
    /**
     * @var BrandInformationDto[]
     */
    private array $brandsDto;

    /**
     * @return BrandInformationDto[]
     */
    public function getBrands(): array
    {
        $brands = FipeCarros::getMarcas();

        foreach ($brands as $brand) {
            $this->brandsDto[] = new BrandInformationDto(
                $brand['nome'],
                "",
                $brand['codigo']
            );
        }

        return $this->brandsDto;
    }
}
