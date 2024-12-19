<?php

namespace App\Actions\CustomerService\Clients;

use App\Models\Client;
use Illuminate\Contracts\Pagination\CursorPaginator;

class SearchClient
{
    public function searchOne(string $id): ?array
    {
        return Client::query()
            ->with(['contacts', 'addresses'])
            ->whereId($id)
            ->first()
            ->toArray();
    }

    public function searchAll(array $filters): CursorPaginator
    {
        $query = Client::query();

        if (!empty($filters['search'])) {
            $query->whereRaw('first_name ILIKE ?', ["%{$filters['search']}%"])
            ->orWhereRaw('last_name ILIKE ?', ["%{$filters['search']}%"])
            ->orWhereRaw('document ILIKE ?', ["%{$filters['search']}%"])
            ->orWhereRaw('entity_type ILIKE ?', ["%{$filters['search']}%"]);
        }

        return $query->cursorPaginate($filters['limit'] ?? 10);
    }

    public function searchByDocument(string $document, string $firstName, string $lastName): ?Client
    {
        return Client::query()
            ->whereDocument($document)
            ->whereFirstName($firstName)
            ->whereLastName($lastName)
            ->first();
    }
}
