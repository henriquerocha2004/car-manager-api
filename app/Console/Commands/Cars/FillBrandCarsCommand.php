<?php

namespace App\Console\Commands\Cars;

use App\Actions\Cars\Implementation\FipeApi\FipePushBrandCars;
use App\Actions\Cars\PushBrandInformation;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FillBrandCarsCommand extends Command
{
    protected $signature = 'cm:fill-brand-cars';
    protected $description = 'Comando que vai obter as marcas de carro para preencher a base de dados';

    public function handle(): void
    {
        try {
            $fipeBrandInformation = new FipePushBrandCars();
            $fillBrandAction = new PushBrandInformation($fipeBrandInformation);
            $fillBrandAction->execute();
        } catch (Exception $exception) {
            Log::error('ERROR_GET_CAR_BRANDS', [
                'message' => $exception->getMessage(),
                'context' => $exception->getTraceAsString(),
            ]);
        }
    }
}
