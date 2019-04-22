<?php

declare(strict_types=1);

namespace App\Http;

use GuzzleHttp\ClientInterface;

class Steam
{
    /** @var ClientInterface */
    private $client;
    /** @var string */
    private $url;
    /** @var string */
    private $apiKey;

    public function __construct(ClientInterface $client, string $url, string $apiKey)
    {
        $this->client = $client;
        $this->url = $url;
        $this->apiKey = $apiKey;
    }

    public function fetch(string $endpoint, array $query): string
    {
        $query['key'] = $this->apiKey;
        $content = $this->client->request('GET', $this->url.$endpoint, ['timeout' => 9, 'query' => $query]);

        return $content->getBody()->getContents();
    }
}
