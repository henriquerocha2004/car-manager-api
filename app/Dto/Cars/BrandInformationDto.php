<?php

namespace App\Dto\Cars;

class BrandInformationDto
{
    public function __construct(
        public string $brand,
        public string $urlLogo,
        public int $fipeCode
    ) {
    }

    public function toArray(): array
    {
        return [
            'brand' => $this->brand,
            'url_logo' => $this->urlLogo,
            'fipe_code' => $this->fipeCode
        ];
    }
}
