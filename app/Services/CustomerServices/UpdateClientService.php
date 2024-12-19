<?php

namespace App\Services\CustomerServices;

use App\Actions\CustomerService\Clients\UpdateClient;
use App\Actions\Shared\Addresses\UpdateAddress;
use App\Actions\Shared\Contacts\UpdateContact;
use App\Dto\Client\ClientRequestDto;

readonly class UpdateClientService
{
    public function __construct(
        private UpdateClient  $updateClient,
        private UpdateAddress $updateAddress,
        private UpdateContact $updateContact,
    ) {
    }

    public function execute(string $id, ClientRequestDto $clientRequestDto): void
    {
        $this->updateClient->execute($id, $clientRequestDto);

        if ($clientRequestDto->addresses) {
            $this->updateAddress->execute($id, $clientRequestDto->addresses);
        }
        if ($clientRequestDto->contacts) {
            $this->updateContact->execute($id, $clientRequestDto->contacts);
        }
    }
}
