<?php

namespace App\Http\Requests;

use App\Dto\Client\ClientRequestDto;
use App\Rules\DocumentRule;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'entity_type' => 'required|string|max:2|in:PF,PJ',
            'document_type' => 'required|string|max:7|in:RG,CPF,CNPJ',
            'document' => ['required', 'string', new DocumentRule($this->input('document_type'))],
            'birth_date' => 'required|date',
            'addresses' => 'nullable|array',
            'contacts' => 'nullable|array',
            'vehicles' => 'nullable|array',
        ];
    }

    public function getData(): ClientRequestDto
    {
        return new ClientRequestDto(
            $this->validated('first_name'),
            $this->validated('last_name'),
            $this->validated('entity_type'),
            $this->validated('document_type'),
            $this->validated('document'),
            $this->validated('birth_date'),
            $this->validated('addresses') ?? [],
            $this->validated('contacts') ?? [],
            $this->validated('vehicles') ?? []
        );
    }
}
