<?php

namespace App\Actions\CustomerService\Clients;

use App\Models\Client;

class DeleteClient
{
    public function execute(string $id): void
    {
        Client::query()->whereId($id)->delete();
    }
}
