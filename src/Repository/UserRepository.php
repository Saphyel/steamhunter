<?php

declare(strict_types=1);

namespace App\Repository;

use App\Http\Steam;

class UserRepository
{
    private const RESOURCE = 'ISteamUser/';

    /** @var Steam */
    private $client;

    public function __construct(Steam $client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed[]
     */
    public function findUserId(string $name): array
    {
        $response = $this->client->fetch(self::RESOURCE.'ResolveVanityURL/v1/', ['vanityurl' => $name]);

        return json_decode($response, true)['response'];
    }

    /**
     * @return mixed[]
     */
    public function findSummary(string $userId): array
    {
        $response = $this->client->fetch(self::RESOURCE.'GetPlayerSummaries/v2/', ['steamids' => $userId]);

        return json_decode($response, true)['response']['players'][0];
    }
}
