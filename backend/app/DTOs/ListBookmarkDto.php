<?php

namespace App\DTOs;

use App\Requests\Bookmark\ListBookmarkRequest;

class ListBookmarkDto
{
    public function __construct(
        public readonly ?string $searchBy = null,
        public readonly ?string $tag = null,
        public readonly ?bool $visitedOnly = null,
        public readonly ?string $sortBy = null,
        public readonly ?string $sortDirection = null,
        public readonly int $perPage = 15
    ) {
    }

    public static function fromRequest(ListBookmarkRequest $request): ListBookmarkDto
    {
        $data = $request->validated();

        return new static(
            searchBy: $data['search_by'] ?? null,
            tag: $data['tag'] ?? null,
            visitedOnly: isset($data['visited_only']) ? (bool) $data['visited_only'] : null,
            sortBy: $data['sort_by'] ?? null,
            sortDirection: $data['sort_direction'] ?? null,
            perPage: isset($data['per_page']) ? (int) $data['per_page'] : 15
        );
    }
}
