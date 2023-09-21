<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Requests\Bookmark\CreateBookmarkRequest;

class CreateBookmarkDto
{
    public function __construct(
        public readonly string $title,
        public readonly string $url,
        public readonly ?string $description = null,
        /** @var int[] $tagsIds */
        public readonly ?array $tagsIds = []
    ) {
    }

    public static function fromRequest(CreateBookmarkRequest $request): CreateBookmarkDto
    {
        $validatedData = $request->validated();

        if (isset($validatedData['tags']) && is_array($validatedData['tags'])) {
            $tagsIds = array_map(fn ($tag) => $tag['id'], $validatedData['tags']);
        }

        return new self(
            title: $validatedData['title'],
            url: $validatedData['url'],
            description: $validatedData['description'] ?? null,
            tagsIds: $tagsIds ?? [],
        );
    }
}
