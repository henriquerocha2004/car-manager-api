<?php

namespace App\Actions\CustomerService\Clients;

use App\Dto\Client\ClientRequestDto;
use App\Models\Client;

class UpdateClient
{
    public function execute(string $id, ClientRequestDto $clientRequest): void
    {
        Client::query()
            ->whereId($id)
            ->update([
                'first_name' => $clientRequest->firstName,
                'last_name' => $clientRequest->lastName,
                'document_type' => $clientRequest->documentType,
                'document' => $clientRequest->document,
                'birth_date' => $clientRequest->birthDate,
                'entity_type' => $clientRequest->entityType,
            ]);
    }
}
