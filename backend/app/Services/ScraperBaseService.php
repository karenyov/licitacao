<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class ScraperBaseService
{
    protected HttpClientInterface $client;

    protected function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getHtml(string $url): string
    {
        $response = $this->client->request('GET', $url);
        return $response->getContent();
    }

}
