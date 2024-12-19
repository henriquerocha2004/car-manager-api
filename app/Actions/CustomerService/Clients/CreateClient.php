<?php

namespace App\Actions\CustomerService\Clients;

use App\Dto\Client\ClientRequestDto;
use App\Models\Client;

class CreateClient
{
    public function execute(ClientRequestDto $clientRequest): ?string
    {
        return Client::query()->create([
            'first_name' => $clientRequest->firstName,
            'last_name' => $clientRequest->lastName,
            'entity_type' => $clientRequest->entityType,
            'document_type' => $clientRequest->documentType,
            'document' => $clientRequest->document,
            'birth_date' => $clientRequest->birthDate,
        ])->id;
    }
}
