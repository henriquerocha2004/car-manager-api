<?php

namespace App\Services\CustomerServices;

use App\Actions\CustomerService\Clients\CreateClient;
use App\Actions\Shared\Addresses\CreateAddress;
use App\Actions\Shared\Contacts\CreateContact;
use App\Dto\Client\ClientRequestDto;
use App\Exceptions\CustomerServices\CreateClientException;

readonly class CreateClientService
{
    public function __construct(
        private CreateClient  $createClient,
        private CreateAddress $createAddress,
        private CreateContact $createContact
    ) {
    }

    /**
     * @throws CreateClientException
     */
    public function execute(ClientRequestDto $clientRequestDto): void
    {
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
    }
}
