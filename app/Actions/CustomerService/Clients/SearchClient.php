<?php

namespace App\Actions\CustomerService\Clients;

use App\Dto\Search\SearchResultDto;
use App\Models\Client;
use App\Shared\Search\Search;
use Illuminate\Contracts\Pagination\CursorPaginator;

class SearchClient
{
    public function searchOne(string $id): ?array
    {
        return Client::query()
            ->with(['contacts', 'addresses', 'cars'])
            ->whereId($id)
            ->first()
            ->toArray();
    }

    public function searchAll(Search $searchDto): SearchResultDto
    {
        $query = Client::query()
            ->selectRaw('*, COUNT(*) OVER() as total')
            ->take($searchDto->limit ?? 10)
            ->offset($searchDto->offset());

        if (!empty($searchDto->search)) {
            $query->whereRaw('first_name ILIKE ?', ["%{$searchDto->search}%"])
            ->orWhereRaw('last_name ILIKE ?', ["%{$searchDto->search}%"])
            ->orWhereRaw('document ILIKE ?', ["%{$searchDto->search}%"])
            ->orWhereRaw('entity_type ILIKE ?', ["%{$searchDto->search}%"]);
        }

        if (!empty($searchDto->sorters)) {
            foreach ($searchDto->sorters as $sorter) {
                $query->orderBy($sorter['field'], $sorter['dir']);
            }
        }

        $result = $query->get();
        $totalPages = $result->first()->total / $searchDto->limit;

        return new SearchResultDto(
           data: $result->toArray(),
           totalPages: $totalPages
        );
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
