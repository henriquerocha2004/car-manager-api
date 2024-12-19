<?php

namespace App\Actions\Shared\Addresses;

use App\Models\Address;

class CreateAddress
{
    public function execute(string $personId, array $addresses): void
    {
        foreach ($addresses as $address) {
            Address::query()->create([
                'person_id' => $personId,
                ... $address
            ]);
        }
    }
}
