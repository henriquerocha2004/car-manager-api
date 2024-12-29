<?php

namespace App\Dto\Search;

class SearchResultDto
{
    public function __construct(
       public readonly int $totalPages,
       public readonly array $data 
    ) {
    }
}
