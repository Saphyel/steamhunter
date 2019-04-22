<?php

declare(strict_types=1);

namespace App\Repository;

use App\Http\Steam;

class StatsRepository
{
    private const RESOURCE = 'ISteamUserStats/';

    /** @var Steam */
    private $client;

    public function __construct(Steam $client)
    {
        $this->client = $client;
    }

    public function findAchievements(string $userId, string $appId): array
    {
        $response = $this->client->fetch(self::RESOURCE.'GetPlayerAchievements/v1/', ['steamid' => $userId, 'appid' => $appId]);

        return json_decode($response, true)['playerstats'];
    }

    public function findGameDetails(string $appId): array
    {
        $response = $this->client->fetch(self::RESOURCE.'GetSchemaForGame/v2/', ['appid' => $appId]);

        return json_decode($response, true)['game']['availableGameStats']['achievements'];
    }
}
