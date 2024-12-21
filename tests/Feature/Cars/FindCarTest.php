<?php

use App\Models\CarBrand;
use App\Models\CarsModel;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\get;

it('should find car with term search', function () {
    CarBrand::factory()
        ->has(CarsModel::factory()->count(3), 'models')
        ->count(3)
        ->create();

    $car = CarsModel::query()->first();

    $response = get("/api/cars?search=$car->model");
    $response->assertStatus(Response::HTTP_OK);
});
