<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\RequiresAuthentication;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;
    use RequiresAuthentication;

    public const BASE_ENDPOINT = '/v1/tags';

    public function test_all_endpoints_requires_authentication()
    {
        $this->getJson(self::BASE_ENDPOINT)->assertUnauthorized();

        $this->postJson(self::BASE_ENDPOINT, ['name' => 'An important tag'])->assertUnauthorized();

        $user = User::factory()->create();
        $tag = $user->tags()->create(['name' => 'An important tag']);

        $this->deleteJson(sprintf('%s/%d', self::BASE_ENDPOINT, $tag->id))->assertUnauthorized();
    }

    public function test_tag_collection_is_returned()
    {
        $user = $this->login();
        $user->tags()->createMany([
            ['name' => 'An import tag'],
            ['name' => 'A very important tag'],
            ['name' => 'A extremely important tag'],
        ]);

        $response = $this->get(self::BASE_ENDPOINT);

        $response->assertOk();
        $response->assertJsonIsObject();
        $response->assertJsonIsArray('data');
        $response->assertJsonCount(3, 'data');
    }

    public function test_user_can_create_tags()
    {
        $this->login();

        $this->postJson(self::BASE_ENDPOINT, ['name' => 'An important tag'])
            ->assertCreated()
            ->assertExactJson([
                'data' => [
                    'id' => 1,
                    'name' => 'An important tag',
                ],
            ]);
    }
}
