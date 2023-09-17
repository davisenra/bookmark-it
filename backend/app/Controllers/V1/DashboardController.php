<?php

declare(strict_types=1);

namespace App\Controllers\V1;

use App\Models\Tag;
use App\Resources\TagResource;
use App\Services\BookmarkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController
{
    public function __construct(
        private readonly BookmarkService $bookmarkService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $bookmarks = $this->bookmarkService->allBookmarksByUser($user);

        $fistDayOfWeek = (new \DateTime('now'))
            ->modify('this week')
            ->setTime(0, 0);

        $tags = Tag::select('id', 'name', 'created_at')
            ->where('user_id', $user->id)
            ->withCount('bookmarks')
            ->get();

        return new JsonResponse([
            'data' => [
                'total_bookmarks' => $bookmarks->count(),
                'total_bookmarks_week' => $bookmarks->where('created_at', '>=', $fistDayOfWeek)->count(),
                'bookmarks_unvisited' => $bookmarks->where('visited_at', '=', null)->count(),
                'tags' => TagResource::collection($tags),
                'total_tags' => $tags->count(),
            ],
        ]);
    }
}
