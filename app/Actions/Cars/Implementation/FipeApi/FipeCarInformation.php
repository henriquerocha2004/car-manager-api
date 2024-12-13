<?php

namespace App\Actions\Cars\Implementation\FipeApi;

use App\Actions\Cars\Contracts\CarInformationInterface;
use App\Dto\Cars\CarInformationDto;
use DeividFortuna\Fipe\FipeCarros;
use Illuminate\Support\Facades\Cache;

class FipeCarInformation extends FipeApiBase implements CarInformationInterface
{
    public const CACHE_KEY_BRAND_CODE_PROCESSED = 'brand_code_%s';
    public const CACHE_KEY_LAST_MODEL_PROCESSED = 'last_model_processed';
    public const CACHE_KEY_LAST_YEAR_PROCESSED = 'last_year_processed';

    /**
     * @var CarInformationDto[]
     */
    private array $cars = [];

    private string $cacheKey;
    private ?array $processInformation = [
        'brand_id' => null,
        'last_model_processed' => null,
        'last_year_processed' => null,
        'finished' => false,
    ];

    /**
     * @param array $params
     * @inheritDoc
     */
    public function getCars(array $params): array
    {
        $this->cars = [];

        if (!$this->isAllowedToMakeMoreRequests()) {
            return [];
        }

        $this->cacheKey = sprintf(self::CACHE_KEY_BRAND_CODE_PROCESSED, $params['fipe_code']);
        $this->processInformation = $this->getCache() ?? [
            'brand_id' => null,
            'last_model_processed' => null,
            'last_year_processed' => null,
            'finished' => false,
        ];

        if (!empty($this->processInformation['finished'])) {
            return [];
        }

        $this->processInformation['brand_id'] = $params['fipe_code'];
        $models = $this->getModels($this->processInformation['brand_id']);

        if (empty($models)) {
            $this->setCache($this->processInformation);

            return $this->cars;
        }

        foreach ($models as $model) {
            if (!empty($this->processInformation) && $model['codigo'] < $this->processInformation['last_model_processed']) {
                continue;
            }

            $this->processInformation['last_model_processed'] = $model['codigo'];

            $yearsModel = $this->getYearModels(
                $this->processInformation['brand_id'],
                $this->processInformation['last_model_processed']
            );

            if (empty($yearsModel)) {
                $this->setCache($this->processInformation);

                return $this->cars;
            }

            foreach ($yearsModel as $yearModel) {
                if (!empty($this->processInformation) && $yearModel['codigo'] < $this->processInformation['last_year_processed']) {
                    continue;
                }

                $this->processInformation['last_year_processed'] = $yearModel['codigo'];

                $car = $this->getCarDetails(
                    $this->processInformation['brand_id'],
                    $this->processInformation['last_model_processed'],
                    $this->processInformation['last_year_processed']
                );

                if (empty($car)) {
                    $this->setCache($this->processInformation);

                    return $this->cars;
                }

                $uniqueCodeCar = "{$model['codigo']}|{$yearModel['codigo']}";
                $this->cars[] = new CarInformationDto(
                    $car['Modelo'],
                    $car['AnoModelo'],
                    $car['Combustivel'],
                    $car['CodigoFipe'],
                    $uniqueCodeCar
                );
            }

            $this->processInformation['last_year_processed'] = null;
        }

        $this->processInformation['finished'] = true;
        $this->processInformation['last_model_processed'] = null;
        $this->setCache($this->processInformation);

        return $this->cars;
    }

    private function getModels(string $brandCode): array
    {
        if (!$this->isAllowedToMakeMoreRequests()) {
            return [];
        }

        $models = FipeCarros::getModelos($brandCode);

        if (empty($models)) {
            return [];
        }

        return collect($models['modelos'])->sortBy('codigo')->toArray();
    }

    private function getYearModels(string $brandCode, string $modelCode): array
    {
        if (!$this->isAllowedToMakeMoreRequests()) {
            return [];
        }

        $yearModels = FipeCarros::getAnos($brandCode, $modelCode);

        if (empty($yearModels)) {
            return [];
        }

        return collect($yearModels)->sortBy('codigo')->toArray();
    }

    private function getCarDetails(string $brandCode, string $modelCode, string $yearModelCode): bool|array
    {
        if (!$this->isAllowedToMakeMoreRequests()) {
            return [];
        }

        $car = FipeCarros::getVeiculo($brandCode, $modelCode, $yearModelCode);

        return $car ?? [];
    }

    private function isAllowedToMakeMoreRequests(): bool
    {
        if ($this->quantityRequestAllowed < 1) {
            return false;
        }

        $this->quantityRequestAllowed = --$this->quantityRequestAllowed;
        return true;
    }

    private function getCache(): ?array
    {
        return json_decode(Cache::get($this->cacheKey), true);
    }

    private function setCache(array $cacheValue): void
    {
        Cache::put($this->cacheKey, json_encode($cacheValue));
    }
}
