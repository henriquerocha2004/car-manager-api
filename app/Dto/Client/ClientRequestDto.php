<?php

namespace App\Dto\Client;

use App\Dto\BaseDto;
use App\Support\Strings\StringHelper;

final class ClientRequestDto extends BaseDto
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $entityType,
        public readonly string $documentType,
        public string $document,
        public readonly string $birthDate,
        public readonly ?array $addresses,
        public readonly ?array $contacts,
        public readonly ?array $vehicles,
    ) {
        $this->document = StringHelper::clear($this->document);
    }
}
