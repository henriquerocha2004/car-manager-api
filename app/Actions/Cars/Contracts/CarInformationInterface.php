<?php

namespace App\Actions\Cars\Contracts;

use App\Dto\Cars\CarInformationDto;

interface CarInformationInterface
{
    /**
     * @return CarInformationDto[]
     */
    public function getCars(array $params): array;
}
