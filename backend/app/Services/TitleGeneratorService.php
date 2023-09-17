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
        private readonly LoggerInterface $logger
    ) {
    }

    public function generate(string $url): ?string
    {
        try {
            $response = $this->httpClient->request('GET', $url);
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage());

            return null;
        }

        $html = $response->getBody()->getContents();

        if (preg_match('/<title>(.*?)<\/title>/', $html, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
