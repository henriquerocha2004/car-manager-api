<?php

namespace App\Actions\Shared\Addresses;

use App\Models\Address;

class UpdateAddress
{
    public function execute(string $personId, array $addresses): void
    {
        Address::query()->wherePersonId($personId)->delete();

        foreach ($addresses as $address) {
            Address::query()->create([
                'person_id' => $personId,
                ...$address
            ]);
        }
    }
}
