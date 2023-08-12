<?php

declare(strict_types=1);

namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Psr\Http\Client\ClientInterface;
use Tests\RequiresAuthentication;
use Tests\TestCase;

class TitleGeneratorTest extends TestCase
{
    use RefreshDatabase;
    use RequiresAuthentication;

    public const BASE_ENDPOINT = '/v1/title-generator';

    public function setUp(): void
    {
        parent::setUp();

        $mock = new MockHandler([
            new Response(200, [], '<html lang="en"><head><title>Github</title></head><body>...</body></html>'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $this->instance(ClientInterface::class, $client);

    }

    public function test_it_requires_authentication()
    {
        $url = self::BASE_ENDPOINT . '?url=https://github.com';

        $this->getJson($url)->assertUnauthorized();
    }

    public function test_it_returns_the_page_title()
    {
        $this->login();

        $url = self::BASE_ENDPOINT . '?url=https://github.com';

        $this->getJson($url)
            ->assertOk()
            ->assertJsonIsObject()
            ->assertExactJson([
                'data' => ['title' => 'Github']
            ]);
    }

    public function test_it_fails_if_no_url_is_provided()
    {
        $this->login();

        $url = self::BASE_ENDPOINT . '?url=thisisnotanurl';

        $this->getJson($url)->assertUnprocessable();
    }
}
