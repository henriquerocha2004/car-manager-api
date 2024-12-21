<?php

namespace App\Services\CustomerServices;

use App\Actions\CustomerService\Clients\AssociateCarClient;
use App\Actions\CustomerService\Clients\CreateClient;
use App\Actions\CustomerService\Clients\SearchClient;
use App\Actions\Shared\Addresses\CreateAddress;
use App\Actions\Shared\Contacts\CreateContact;
use App\Dto\Client\ClientRequestDto;
use App\Exceptions\CustomerServices\CreateClientException;

readonly class CreateClientService
{
    public function __construct(
        private CreateClient  $createClient,
        private CreateAddress $createAddress,
        private CreateContact $createContact,
        private SearchClient $searchClient,
        private AssociateCarClient $associateCarClient,
    ) {
    }

    /**
     * @throws CreateClientException
     */
    public function execute(ClientRequestDto $clientRequestDto): void
    {
        $clientExistis = $this->searchClient->searchByDocument(
            $clientRequestDto->document,
            $clientRequestDto->firstName,
            $clientRequestDto->lastName,
        );

        if ($clientExistis) {
            throw new CreateClientException('Client already exists.');
        }

        $clientId = $this->createClient->execute($clientRequestDto);

        if (is_null($clientId)) {
            throw new CreateClientException('Unable to create client');
        }

        if (!empty($clientRequestDto->addresses)) {
            $this->createAddress->execute($clientId, $clientRequestDto->addresses);
        }

        if (!empty($clientRequestDto->contacts)) {
            $this->createContact->execute($clientId, $clientRequestDto->contacts);
        }

        if (!empty($clientRequestDto->vehicles)) {
            $this->associateCarClient->execute($clientId, $clientRequestDto->vehicles);
        }
    }
}
