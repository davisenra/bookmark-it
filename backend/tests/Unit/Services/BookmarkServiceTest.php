<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\DTOs\CreateBookmarkDto;
use App\DTOs\UpdateBookmarkDto;
use App\Models\Bookmark;
use App\Models\User;
use App\Services\BookmarkService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookmarkServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_a_user_bookmarks()
    {
        $user = User::factory()->create();
        $bookmark1 = Bookmark::factory()->create(['user_id' => $user->id]);
        $bookmark2 = Bookmark::factory()->create(['user_id' => $user->id]);

        $bookmarkService = new BookmarkService();
        $bookmarks = $bookmarkService->allBookmarksByUser($user);

        $this->assertInstanceOf(Collection::class, $bookmarks);
        $this->assertCount(2, $bookmarks);
        $this->assertTrue($bookmarks->contains($bookmark1));
        $this->assertTrue($bookmarks->contains($bookmark2));
    }

    public function test_it_only_returns_bookmarks_from_specific_user()
    {
        $user1 = User::factory()->create();
        Bookmark::factory()->create(['user_id' => $user1->id]);

        $user2 = User::factory()->create();
        $bookmark1 = Bookmark::factory()->create(['user_id' => $user2->id]);
        $bookmark2 = Bookmark::factory()->create(['user_id' => $user2->id]);

        $bookmarkService = new BookmarkService();
        $bookmarks = $bookmarkService->allBookmarksByUser($user2);

        $this->assertInstanceOf(Collection::class, $bookmarks);
        $this->assertCount(2, $bookmarks);
        $this->assertTrue($bookmarks->contains($bookmark1));
        $this->assertTrue($bookmarks->contains($bookmark2));
    }

    public function test_can_create_a_bookmark()
    {
        $user = User::factory()->create();

        $createBookmarkDto = new CreateBookmarkDto(
            'A random title',
            'https://github.com/davisenra/bookmark-it',
            'Random description',
        );

        $bookmarkService = new BookmarkService();
        $bookmark = $bookmarkService->createBookmark($user, $createBookmarkDto);
        $sameBookmark = $bookmarkService->getUserBookmarkById($user, $bookmark->id);

        $this->assertInstanceOf(Bookmark::class, $bookmark);
        $this->assertTrue($bookmark->id !== null);
        $this->assertTrue($bookmark->title === 'A random title');
        $this->assertTrue($bookmark->url === 'https://github.com/davisenra/bookmark-it');
        $this->assertTrue($bookmark->id === $sameBookmark->id);
    }

    public function test_it_can_delete_a_bookmark()
    {
        $user = User::factory()->create();
        $bookmark = Bookmark::factory()->create(['user_id' => $user->id]);

        $bookmarkService = new BookmarkService();

        $createdBookmark = $bookmarkService->getUserBookmarkById($user, $bookmark->id);
        $this->assertInstanceOf(Bookmark::class, $createdBookmark);
        $this->assertTrue($createdBookmark->id !== null);

        $bookmarkService->deleteBookmark($bookmark);

        $deletedBookmark = $bookmarkService->getUserBookmarkById($user, $bookmark->id);

        $this->assertNull($deletedBookmark);
    }

    public function test_a_bookmark_can_be_updated()
    {
        $user = User::factory()->create();

        $createBookmarkDto = new CreateBookmarkDto(
            'A random title',
            'https://github.com/davisenra/bookmark-it',
            'Random description',
        );

        $bookmarkService = new BookmarkService();
        $bookmark = $bookmarkService->createBookmark($user, $createBookmarkDto);

        $this->assertTrue($bookmark->title === 'A random title');
        $this->assertTrue($bookmark->url === 'https://github.com/davisenra/bookmark-it');

        $updateBookmarkDto = new UpdateBookmarkDto(
            title: 'A new title',
            url: 'https://google.com'
        );

        $bookmarkService->updateBookmark($bookmark, $updateBookmarkDto);
        $updatedBookmark = $bookmarkService->getUserBookmarkById($user, $bookmark->id);

        $this->assertTrue($updatedBookmark->id === $bookmark->id);
        $this->assertTrue($updatedBookmark->title === 'A new title');
        $this->assertTrue($updatedBookmark->url === 'https://google.com');
    }
}
