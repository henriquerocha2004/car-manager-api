<?php

namespace App\Dto\Cars;

class CarInformationDto
{
    public function __construct(
        public string $model,
        public string $year,
        public string $fuel,
        public string $fipeCode,
        public string $fipeLibModelCode
    ) {
    }
}
