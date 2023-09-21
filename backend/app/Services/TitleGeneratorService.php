<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;

final class TitleGeneratorService
{
    public function __construct(
        private readonly ClientInterface $httpClient,
        private readonly ?LoggerInterface $logger = null
    ) {
    }

    public function generate(string $url): ?string
    {
        try {
            $response = $this->httpClient->request('GET', $url, [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36',
                ],
            ]);
        } catch (GuzzleException $e) {
            $this->logger?->error($e->getMessage());

            return null;
        }

        $html = $response->getBody()->getContents();

        return $this->extractTitleFromHtml($html);
    }

    private function extractTitleFromHtml(string $htmlContent): ?string
    {
        if (preg_match('/<title>(.*?)<\/title>/', $htmlContent, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
