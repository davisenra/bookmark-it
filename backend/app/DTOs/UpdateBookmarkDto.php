<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Requests\Bookmark\UpdateBookmarkRequest;

class UpdateBookmarkDto
{
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $description = null,
        /** @var int[] $tagsIds */
        public readonly array $tagsIds = []
    ) {
    }

    public static function fromRequest(UpdateBookmarkRequest $request): UpdateBookmarkDto
    {
        $validatedData = $request->validated();

        if (isset($validatedData['tags']) && is_array($validatedData['tags'])) {
            $tagsIds = array_map(fn ($tag) => $tag['id'], $validatedData['tags']);
        }

        return new self(
            title: $validatedData['title'] ?? null,
            description: $validatedData['description'] ?? null,
            tagsIds: $tagsIds ?? [],
        );
    }
}
