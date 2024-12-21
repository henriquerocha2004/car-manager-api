<?php

namespace App\Actions\CustomerService\Clients;

use Illuminate\Support\Facades\DB;

class AssociateCarClient
{
    public function execute(string $clientId, array $carsIds): void
    {
        DB::table('client_cars')->where('client_id', $clientId)->delete();

        foreach ($carsIds as $carId) {
            DB::table('client_cars')->insert([
                'client_id' => $clientId,
                'car_id' => $carId
            ]);
        }
    }
}
