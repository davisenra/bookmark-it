<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class BookmarkService
{
    /**
     * @param User $user
     * @param string[] $options
     * @return LengthAwarePaginator<Bookmark>
     */
    public function allBookmarksByUser(User $user, array $options = []): LengthAwarePaginator
    {
        $paginationSize = isset($options['per_page']) ? (int) $options['per_page'] : 15;

        $queryBuilder = Bookmark::query()
            ->where('user_id', $user->id)
            ->with('tags');

        if (isset($options['visited_only'])) {
            $options['visited_only']
                ? $queryBuilder->whereNotNull('visited_at')
                : $queryBuilder->whereNull('visited_at');
        }

        if (isset($options['sort_by'])) {
            $orderDirection = $options['sort_direction'] ?? 'DESC';
            $queryBuilder->orderBy($options['sort_by'], $orderDirection);
        } else {
            $queryBuilder->orderBy('created_at', 'DESC');
        }

        if (isset($options['tag'])) {
            $tagName = $options['tag'];
            $queryBuilder->whereHas('tags', function ($query) use ($tagName) {
                $query->where('name', $tagName);
            });
        }

        return $queryBuilder->paginate($paginationSize);
    }

    public function getUserBookmarkById(User $user, string $id): ?Bookmark
    {
        $bookmark = $user->bookmarks()->where('id', $id)->first();

        if ($bookmark instanceof Bookmark) {
            return $bookmark;
        }

        return null;
    }

    /**
     * @param User $user
     * @param array<string, mixed> $validatedData
     * @return Bookmark
     */
    public function createBookmark(User $user, array $validatedData): Bookmark
    {
        $bookmark = new Bookmark();
        $bookmark->title = $validatedData['title'];
        $bookmark->description = $validatedData['description'] ?? null;
        $bookmark->url = $validatedData['url'];
        $bookmark->user()->associate($user);
        $bookmark->save();

        $bookmarkHasTags = !empty($validatedData['tags']);

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
     * @param Bookmark|null $bookmark
     * @param array<string, mixed> $validatedData
     * @return void
     */
    public function updateBookmark(?Bookmark $bookmark, array $validatedData): void
    {
        $bookmark->update($validatedData);

        $bookmarkHasTags = !empty($validatedData['tags']);

        if ($bookmarkHasTags) {
            $tagsIds = array_map(fn ($tag) => $tag['id'], $validatedData['tags']);
            $tags = $bookmark->user->tags()->whereIn('id', $tagsIds)->get();
            $bookmark->tags()->toggle($tags);
        }
    }
}
