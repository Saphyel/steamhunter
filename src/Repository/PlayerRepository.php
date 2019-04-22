<?php

declare(strict_types=1);

namespace App\Repository;

use App\Http\Steam;

class PlayerRepository
{
    private const RESOURCE = 'IPlayerService/';

    /** @var Steam */
    private $client;

    public function __construct(Steam $client)
    {
        $this->client = $client;
    }

    public function findGames(string $userId): array
    {
        $response = $this->client->fetch(
            self::RESOURCE.'GetOwnedGames/v1/',
            ['steamid' => $userId, 'include_appinfo' => '1']
        );

        return json_decode($response, true)['response']['games'];
    }
}
