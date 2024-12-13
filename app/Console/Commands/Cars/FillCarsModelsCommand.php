<?php

namespace App\Console\Commands\Cars;

use App\Actions\Cars\Implementation\FipeApi\FipeCarInformation;
use App\Actions\Cars\PushCarsInformation;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FillCarsModelsCommand extends Command
{
    protected $signature = 'app:fill-cars-models-command';
    protected $description = 'Command description';

    public function handle(): void
    {
        try {
            $fipeCarInfo = new FipeCarInformation();
            $pushCarsAction = new PushCarsInformation($fipeCarInfo);
            $pushCarsAction->execute();

        } catch (Exception $exception) {
            Log::error('ERROR_GET_CAR_MODELS', [
                'message' => $exception->getMessage(),
                'context' => $exception->getTraceAsString(),
            ]);
        }
    }
}
