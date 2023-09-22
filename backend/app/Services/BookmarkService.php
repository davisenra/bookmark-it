<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\CreateBookmarkDto;
use App\DTOs\ListBookmarkDto;
use App\DTOs\UpdateBookmarkDto;
use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BookmarkService
{
    public function allBookmarksByUser(User $user): Collection
    {
        return Bookmark::all()->where('user_id', $user->id);
    }

    /**
     * @return LengthAwarePaginator<Bookmark>
     */
    public function allBookmarksPaginatedByUser(User $user, ListBookmarkDto $options): LengthAwarePaginator
    {
        $paginationSize = $options->perPage;

        $queryBuilder = Bookmark::query()
            ->where('user_id', $user->id)
            ->with('tags');

        if ($options->visitedOnly !== null) {
            $options->visitedOnly
                ? $queryBuilder->whereNotNull('visited_at')
                : $queryBuilder->whereNull('visited_at');
        }

        if ($options->searchBy !== null) {
            $queryBuilder->whereRaw('LOWER(title) LIKE ?', [
                "%$options->searchBy%"
            ]);
        }

        if ($options->sortBy !== null) {
            $orderDirection = $options->sortDirection ?? 'DESC';
            $queryBuilder->orderBy($options->sortBy, $orderDirection);
        } else {
            $queryBuilder->orderBy('created_at', 'DESC');
        }

        if ($options->tag !== null) {
            $tagName = $options->tag;
            $queryBuilder->whereHas('tags', function ($query) use ($tagName) {
                $query->where('name', $tagName);
            });
        }

        return $queryBuilder->paginate($paginationSize);
    }

    public function getUserBookmarkById(User $user, string $bookmarkId): ?Bookmark
    {
        $bookmark = $user->bookmarks()->where('id', $bookmarkId)->first();

        if ($bookmark instanceof Bookmark) {
            return $bookmark;
        }

        return null;
    }

    public function createBookmark(User $user, CreateBookmarkDto $createBookmark): Bookmark
    {
        $bookmark = new Bookmark();
        $bookmark->title = $createBookmark->title;
        $bookmark->description = $createBookmark->description ?? null;
        $bookmark->url = $createBookmark->url;
        $bookmark->user()->associate($user);
        $bookmark->save();

        $bookmarkHasTags = !empty($createBookmark->tagsIds);

        if ($bookmarkHasTags) {
            $tagsIds = $createBookmark->tagsIds;
            $tags = $user->tags()->whereIn('id', $tagsIds)->get();
            $bookmark->tags()->sync($tags);
        }

        return $bookmark;
    }

    public function deleteBookmark(Bookmark $bookmark): void
    {
        $bookmark->tags()->detach();
        $bookmark->delete();
    }

    public function toggleVisitedStatus(Bookmark $bookmark): void
    {
        if ($bookmark->visited_at !== null) {
            $bookmark->update(['visited_at' => null]);

            return;
        }

        $bookmark->update(['visited_at' => new \DateTimeImmutable('now')]);
    }

    public function updateBookmark(Bookmark $bookmark, UpdateBookmarkDto $updateBookmark): void
    {
        $attributesToUpdate = [
            'title' => $updateBookmark->title,
            'url' => $updateBookmark->url,
            'description' => $updateBookmark->description,
        ];

        $bookmark->update(array_filter($attributesToUpdate));

        $bookmarkHasTags = !empty($updateBookmark->tagsIds);

        if ($bookmarkHasTags) {
            $tagsIds = $updateBookmark->tagsIds;
            $tags = $bookmark->user->tags()->whereIn('id', $tagsIds)->get();
            $bookmark->tags()->sync($tags);
        }
    }
}
