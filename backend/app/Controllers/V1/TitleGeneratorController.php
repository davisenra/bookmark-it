<?php

declare(strict_types=1);

namespace App\Controllers\V1;

use App\Requests\GenerateTitleRequest;
use App\Services\TitleGeneratorService;
use Illuminate\Http\JsonResponse;

class TitleGeneratorController
{
    public function __construct(
        private readonly TitleGeneratorService $titleGeneratorService,
    ) {
    }

    public function generate(GenerateTitleRequest $request): JsonResponse
    {
        $url = $request->validated('url');
        $title = $this->titleGeneratorService->generate($url);

        if (! $title) {
            return new JsonResponse(['data' => ['title' => null]], 400);
        }

        return new JsonResponse(['data' => ['title' => $title]]);
    }
}
