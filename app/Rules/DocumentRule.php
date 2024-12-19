<?php

namespace App\Rules;

use App\Support\Document\ValidateCPFCNPJ;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;
use Throwable;

class DocumentRule implements ValidationRule
{
    public function __construct(private readonly ?string $typeDocument)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->typeDocument == 'RG') {
            return;
        }

        try {
            new ValidateCPFCNPJ($value);
        } catch (Throwable $throwable) {
            Log::error('FAILED_DOCUMENT_VALIDATION', [
                'message' => $throwable->getMessage(),
                'context' => $throwable->getTraceAsString(),
            ]);
            $fail('O CPF/CNPJ Informado é inválido');
        }
    }
}
