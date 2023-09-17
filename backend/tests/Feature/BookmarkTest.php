<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Bookmark;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\RequiresAuthentication;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;
    use RequiresAuthentication;

    public const BASE_ENDPOINT = '/v1/bookmarks';

    public function test_all_endpoints_requires_authentication()
    {
        $this->getJson(self::BASE_ENDPOINT)->assertUnauthorized();
        $this->postJson(self::BASE_ENDPOINT)->assertUnauthorized();
        $this->postJson(self::BASE_ENDPOINT.'/1')->assertUnauthorized();
        $this->getJson(self::BASE_ENDPOINT.'/1')->assertUnauthorized();
        $this->deleteJson(self::BASE_ENDPOINT.'/1')->assertUnauthorized();
        $this->patchJson(self::BASE_ENDPOINT.'/1/visited')->assertUnauthorized();
    }

    public function test_bookmark_collection_is_returned()
    {
        $user = $this->login();

        $user->bookmarks()->saveMany(Bookmark::factory(3)->make());

        $this->getJson(self::BASE_ENDPOINT)
            ->assertOk()
            ->assertJsonIsObject()
            ->assertJsonCount(3, 'data');
    }

    public function test_bookmark_collection_can_be_paginated()
    {
        $user = $this->login();

        $user->bookmarks()->saveMany(Bookmark::factory(20)->make());

        $response = $this->getJson(self::BASE_ENDPOINT);

        $this->assertCount(20, $user->bookmarks->toArray());

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
        $response->assertJsonPath('meta.per_page', 15);
        $response->assertJsonPath('meta.last_page', 2);
    }

    public function test_bookmark_collection_can_be_filtered_by_tag()
    {
        $user = $this->login();
        $userTags = $user->tags()->saveMany(Tag::factory(2)->make());

        /** @var Bookmark[] $bookmarks */
        $bookmarks = Bookmark::factory(10)->create(['user_id' => $user->id]);
        $tagIndex = 0;

        foreach ($bookmarks as $bookmark) {
            $bookmark->tags()->sync($userTags[$tagIndex]->id);
            $tagIndex = ($tagIndex + 1) % 2;
        }

        $this->assertCount(10, $user->bookmarks);

        $this->getJson(self::BASE_ENDPOINT.'?'.Arr::query(['tag' => $userTags[0]->name]))
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function test_only_user_bookmarks_are_returned()
    {
        $user1 = User::factory()->create();
        $user1->bookmarks()->saveMany(Bookmark::factory(2)->make());

        $user2 = $this->login();
        $user2->bookmarks()->saveMany(Bookmark::factory(2)->make());

        $response = $this->getJson(self::BASE_ENDPOINT);

        $response->assertOk();
        $response->assertJsonCount(2, 'data');
    }

    public function test_user_can_create_bookmark()
    {
        $user = $this->login();

        $response = $this->postJson(self::BASE_ENDPOINT, [
            'title' => 'Very important bookmark',
            'url' => 'https://veryimportantwebsite.com',
        ]);

        $response->assertCreated();
        $response->assertJsonPath('data.title', 'Very important bookmark');
        $response->assertJsonPath('data.url', 'https://veryimportantwebsite.com');

        $this->assertCount(1, $user->bookmarks);
    }

    public function test_create_bookmark_validation()
    {
        $this->login();

        $this->postJson(self::BASE_ENDPOINT, ['title' => 'Very important bookmark'])
            ->assertStatus(422)
            ->assertJsonPath('message', 'The url field is required.');

        $this->postJson(self::BASE_ENDPOINT, ['url' => 'https://veryimportantwebsite.com'])
            ->assertStatus(422)
            ->assertJsonPath('message', 'The title field is required.');
    }

    public function test_bookmark_can_be_marked_as_visited()
    {
        $user = $this->login();
        $bookmark = Bookmark::factory()->make();
        $bookmark->visited_at = null;
        $bookmark->user()->associate($user);
        $bookmark->save();

        $endpoint = sprintf('%s/%s/visited', self::BASE_ENDPOINT, $bookmark->id);

        $this->patchJson($endpoint)
            ->assertNoContent();

        $this->getJson(self::BASE_ENDPOINT."/{$bookmark->id}")
            ->assertOk()
            ->assertJsonPath('data.visited', true);
    }

    public function test_bookmark_can_be_deleted()
    {
        $user = $this->login();
        $bookmark = $user->bookmarks()->save(Bookmark::factory()->make());

        $this->deleteJson(self::BASE_ENDPOINT."/{$bookmark->id}")
            ->assertNoContent();

        $this->assertCount(0, $user->bookmarks);
    }

    public function test_bookmark_can_be_updated()
    {
        $user = $this->login();
        $bookmark = $user->bookmarks()->save(Bookmark::factory()->make());

        $payload = [
            'title' => 'A new title',
            'description' => 'A new description',
        ];

        $this->postJson(self::BASE_ENDPOINT."/{$bookmark->id}", $payload)
            ->assertOk()
            ->assertJsonPath('data.title', $payload['title'])
            ->assertJsonPath('data.description', $payload['description']);
    }

    public function test_can_filter_by_bookmark_title()
    {
        $user = $this->login();
        $user->bookmarks()->saveMany(Bookmark::factory(5)->make());

        $this->postJson(self::BASE_ENDPOINT, [
            'title' => 'A very specific title',
            'url' => 'https://veryimportantwebsite.com',
        ]);

        $this->postJson(self::BASE_ENDPOINT, [
            'title' => 'A kinda of specific title',
            'url' => 'https://veryimportantwebsite.com',
        ]);

        $response = $this->getJson(self::BASE_ENDPOINT.'?'.Arr::query(['search_by' => 'specific title']));
        $response->assertOk();
        $response->assertJsonCount(2, 'data');
        $response->assertJsonPath('data.0.title', 'A very specific title');
        $response->assertJsonPath('data.1.title', 'A kinda of specific title');
    }
}
