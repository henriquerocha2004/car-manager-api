<?php

namespace App\Actions\Shared\Contacts;

use App\Models\Contact;

class CreateContact
{
    public function execute(string $personId, array $contacts): void
    {
        foreach ($contacts as $contact) {
            Contact::query()->create([
               'person_id' => $personId,
               ... $contact,
            ]);
        }
    }
}
