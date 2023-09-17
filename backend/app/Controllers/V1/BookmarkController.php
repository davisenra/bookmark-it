<?php

declare(strict_types=1);

namespace App\Controllers\V1;

use App\DTOs\ListBookmarkDto;
use App\Models\User;
use App\Requests\Bookmark\CreateBookmarkRequest;
use App\Requests\Bookmark\ListBookmarkRequest;
use App\Requests\Bookmark\UpdateBookmarkRequest;
use App\Resources\BookmarkResource;
use App\Services\BookmarkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class BookmarkController
{
    public function __construct(
        private readonly BookmarkService $bookmarkService
    ) {
    }

    public function index(ListBookmarkRequest $request): JsonResource
    {
        /** @var User $user */
        $user = $request->user();
        $listBookmarkDto = ListBookmarkDto::fromRequest($request);
        $userBookmarks = $this->bookmarkService->allBookmarksPaginatedByUser($user, $listBookmarkDto);

        return BookmarkResource::collection($userBookmarks);
    }

    public function show(Request $request, string $id): Response|JsonResource
    {
        /** @var User $user */
        $user = $request->user();

        $bookmark = $this->bookmarkService->getUserBookmarkById($user, $id);

        if ($bookmark === null) {
            return new Response(null, 404);
        }

        return new BookmarkResource($bookmark);
    }

    public function store(CreateBookmarkRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $validatedData = $request->validated();

        $bookmark = $this->bookmarkService->createBookmark($user, $validatedData);

        return (new BookmarkResource($bookmark))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateBookmarkRequest $request, string $id)
    {
        /** @var User $user */
        $user = $request->user();

        $bookmark = $this->bookmarkService->getUserBookmarkById($user, $id);
        $this->bookmarkService->updateBookmark($bookmark, $request->validated());

        return (new BookmarkResource($bookmark))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Request $request, string $id): Response
    {
        /** @var User $user */
        $user = $request->user();

        $bookmark = $this->bookmarkService->getUserBookmarkById($user, $id);

        if ($bookmark === null) {
            return new Response(null, 404);
        }

        $this->bookmarkService->deleteBookmark($bookmark);

        return new Response(null, 204);
    }

    public function visited(Request $request, string $id): Response
    {
        /** @var User $user */
        $user = $request->user();

        $bookmark = $this->bookmarkService->getUserBookmarkById($user, $id);

        if ($bookmark === null) {
            return new Response(null, 404);
        }

        $this->bookmarkService->setAsVisited($bookmark);

        return new Response(null, 204);
    }
}
