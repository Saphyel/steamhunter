<?php

declare(strict_types=1);

namespace App\Http;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Steam
{
    /** @var HttpClientInterface */
    private $client;
    /** @var string */
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * @param mixed[] $query
     */
    public function fetch(string $endpoint, array $query): string
    {
        $query['key'] = $this->apiKey;
        $content = $this->client->request('GET', $endpoint, ['query' => $query]);

        return $content->getContent();
    }
}
