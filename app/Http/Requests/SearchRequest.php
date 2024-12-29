<?php

namespace App\Http\Requests;

use App\Shared\Search\Search;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => 'required|integer',
            'size' => 'required|integer',
            'sorters' => 'array|nullable',
            'search' => 'string|nullable',
        ];
    }

    public function getData(): Search
    {
        return new Search(
            page: $this->validated('page', 1),
            limit: $this->validated('size'),
            sorters: $this->validated('sorters', []),
            search: $this->validated('search', ''),
        );
    }
}
