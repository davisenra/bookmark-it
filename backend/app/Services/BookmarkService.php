<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ListBookmarkDto;
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

    /**
     * @param  array<string, mixed>  $validatedData
     */
    public function createBookmark(User $user, array $validatedData): Bookmark
    {
        $bookmark = new Bookmark();
        $bookmark->title = $validatedData['title'];
        $bookmark->description = $validatedData['description'] ?? null;
        $bookmark->url = $validatedData['url'];
        $bookmark->user()->associate($user);
        $bookmark->save();

        $bookmarkHasTags = ! empty($validatedData['tags']);

        if ($bookmarkHasTags) {
            $tagsIds = array_map(fn ($tag) => $tag['id'], $validatedData['tags']);
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

    public function setAsVisited(?Bookmark $bookmark): void
    {
        if ($bookmark->visited_at !== null) {
            $bookmark->update(['visited_at' => null]);

            return;
        }

        $bookmark->update(['visited_at' => new \DateTimeImmutable('now')]);
    }

    /**
     * @param  array<string, mixed>  $validatedData
     */
    public function updateBookmark(?Bookmark $bookmark, array $validatedData): void
    {
        $bookmark->update($validatedData);

        $bookmarkHasTags = ! empty($validatedData['tags']);

        if ($bookmarkHasTags) {
            $tagsIds = array_map(fn ($tag) => $tag['id'], $validatedData['tags']);
            $tags = $bookmark->user->tags()->whereIn('id', $tagsIds)->get();
            $bookmark->tags()->toggle($tags);
        }
    }
}
