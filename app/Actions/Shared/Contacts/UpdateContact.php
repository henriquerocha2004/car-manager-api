<?php

namespace App\Actions\Shared\Contacts;

use App\Models\Contact;

class UpdateContact
{
    public function execute(string $personId, array $contacts): void
    {
        Contact::query()->wherePersonId($personId)->delete();
        foreach ($contacts as $contact) {
            Contact::query()->create([
                'person_id' => $personId,
                ... $contact
            ]);
        }
    }
}
