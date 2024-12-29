<?php

use App\Http\Controllers\ClientController;
use App\Models\CarBrand;
use App\Models\CarsModel;
use App\Models\Client;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
use const App\Models\CarBrand;

covers(ClientController::class);

it('can create a new client', function () {
    $response = post('/api/client', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'entity_type' => 'PF',
        'document_type' => 'CPF',
        'document' => '270.017.120-94',
        'birth_date' => '1990-01-01',
    ]);
    $response->assertStatus(Response::HTTP_CREATED);
    $this->assertDatabaseHas('clients', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'entity_type' => 'PF',
        'document_type' => 'CPF',
        'document' => '27001712094',
        'birth_date' => '1990-01-01',
    ]);
});

it('should create new client with addresses', function () {
    $response = post('/api/client', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'entity_type' => 'PF',
        'document_type' => 'CPF',
        'document' => '270.017.120-94',
        'birth_date' => '1990-01-01',
        'addresses' => [
            [
                'street' => '123 Street',
                'city' => 'City',
                'state' => 'State',
                'zip_code' => '1234456',
                'neighborhood' => 'Neighborhood',
                'description' => 'WORK'
            ]
        ],
    ]);

    $response->assertStatus(Response::HTTP_CREATED);
    $this->assertDatabaseHas('addresses', [
        'street' => '123 Street',
        'city' => 'City',
        'state' => 'State',
        'zip_code' => '1234456',
        'neighborhood' => 'Neighborhood',
        'description' => 'WORK'
    ]);
});

it('should create new client with contact', function () {
    $response = post('/api/client', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'entity_type' => 'PF',
        'document_type' => 'CPF',
        'document' => '270.017.120-94',
        'birth_date' => '1990-01-01',
        'contacts' => [
            [
                'type' => 'email',
                'contact' => 'test@example.com',
            ]
        ],
    ]);

    $response->assertStatus(Response::HTTP_CREATED);
    $this->assertDatabaseHas('contacts', [
        'type' => 'email',
        'contact' => 'test@example.com',
    ]);
});

it('should return error if required data is not provided in create client', function () {
    $response = post('/api/client', [], ['accept' => 'application/json']);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('should update client with success', function () {
    $client = Client::factory()->create();

    $response = put("/api/client/{$client->id}", [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'entity_type' => 'PF',
        'document_type' => 'CPF',
        'document' => '270.017.120-94',
        'birth_date' => '1990-01-01',
        'addresses' => [
            [
                'street' => '123 Street',
                'city' => 'City',
                'state' => 'State',
                'zip_code' => '1234456',
                'neighborhood' => 'Neighborhood',
                'description' => 'WORK'
            ]
        ],
        'contacts' => [
            [
                'type' => 'email',
                'contact' => 'test@example.com',
            ]
        ]
    ]);

    $response->assertStatus(Response::HTTP_OK);
    $this->assertDatabaseHas('clients', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'entity_type' => 'PF',
        'document_type' => 'CPF',
        'document' => '27001712094',
        'birth_date' => '1990-01-01',
    ]);
});

it('should delete client with success', function () {
    $client = Client::factory()->create();

    $response = delete("/api/client/{$client->id}");
    $response->assertStatus(Response::HTTP_OK);

    $dbClient = Client::query()->find($client->id);
    expect($dbClient)->toBeNull();
});

it('should retrieve one client', function () {
    $client = Client::factory()->create();
    $response = get("/api/client/{$client->id}");
    $response->assertStatus(Response::HTTP_OK);
    $dataResponse = json_decode($response->getContent(), true);
    expect($dataResponse['data']['first_name'])->toBe($client->first_name)
        ->and($dataResponse['data']['last_name'])->toBe($client->last_name);
});

it('should retrieve clients by filter', function () {
    Client::factory()->count(7)->create();

    $response = get("/api/client?size=5&page=1");
    $dataResponse = json_decode($response->getContent(), true);
    expect($dataResponse['data'])->toHaveCount(5);

    $client = Client::query()->first();

    $response = get("/api/client?size=5&page=2&sorters[0][field]=first_name&sorters[0][dir]=asc");
    $dataResponse = json_decode($response->getContent(), true);
    expect($dataResponse['data'])->toHaveCount(2);

    $response = get("/api/client?size=5&page=1&search={$client->first_name}");
    $dataResponse = json_decode($response->getContent(), true);
    expect($dataResponse['data'])
        ->toHaveCount(1)
        ->and($dataResponse['data'][0]['first_name'])->toBe($client->first_name);

    $response = get("/api/client?size=5&page=1&search={$client->last_name}");
    $dataResponse = json_decode($response->getContent(), true);
    expect($dataResponse['data'])
        ->toHaveCount(1)
        ->and($dataResponse['data'][0]['last_name'])->toBe($client->last_name);

    $response = get("/api/client?size=5&page=1&search={$client->document}");
    $dataResponse = json_decode($response->getContent(), true);
    expect($dataResponse['data'])
        ->toHaveCount(1)
        ->and($dataResponse['data'][0]['document'])->toBe($client->document);
});

it('should return error if client already exists on try create', function () {
    $client = Client::factory()->create([
        'document' => '66179095000',
    ]);
    $response = post("/api/client", [
        'first_name' => $client->first_name,
        'last_name' => $client->last_name,
        'entity_type' => 'PF',
        'document_type' => 'CPF',
        'document' => $client->document,
        'birth_date' => '1990-01-01'
    ], ['accept' => 'application/json']);

    $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
});

it('should create client with cars associated', function () {
    $brandsWithCars = CarBrand::factory()
        ->has(CarsModel::factory()->count(3), 'models')
        ->count(3)
        ->create();
    $carsIds = $brandsWithCars->first()->models()->get()->pluck('id')->toArray();

    $response = post('/api/client', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'entity_type' => 'PF',
        'document_type' => 'CPF',
        'document' => '270.017.120-94',
        'birth_date' => '1990-01-01',
        'vehicles' => $carsIds,
    ]);

    $response->assertStatus(Response::HTTP_CREATED);
    $client = Client::query()->first();
    $cars = $client->cars()->get();

    expect($cars->count())->toBe(3);
});
