<?php

use DeividFortuna\Fipe\FipeCarros;
use DeividFortuna\Fipe\IFipe;

it('should retrieve car brand', function () {
    $token = env('FIPE_TOKEN');
    IFipe::setCurlOptions([
        CURLOPT_HTTPHEADER => ["X-Subscription-Token: {$token}"],
    ]);

//    $brands = FipeCarros::getMarcas();
    $cars = FipeCarros::getModelos(1);
    $anos = FipeCarros::getAnos(21, 437);
    $carro = FipeCarros::getVeiculo(21, 437, "1987-1");
    dd($cars);
});
