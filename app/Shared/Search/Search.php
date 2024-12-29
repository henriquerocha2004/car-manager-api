<?php

namespace App\Shared\Search;

class Search
{
    private int $offset;

    public function __construct(
        public readonly int $page,
        public readonly int $limit,
        public readonly array $sorters = [],
        public readonly ?string $search = ''
    ) {
        $this->defineOffset($this->page);
    }

    private function defineOffset(int $page): void
    {
        if (empty($page)) {
            $page = 1;
        }

        $this->offset = ($page * $this->limit) - $this->limit;
    }

    public function offset(): int
    {
        return $this->offset;
    }
}
