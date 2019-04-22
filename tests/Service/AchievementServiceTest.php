<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Http\Steam;
use App\Model\Achievement;
use App\Model\GameProgression;
use App\Repository\StatsRepository;
use App\Service\AchievementService;
use App\Transformer\AchievementTransformer;
use App\Transformer\GameProgressionTransformer;
use Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AchievementServiceTest extends TestCase
{
    /** @var MockObject&Steam */
    private $client;
    /** @var AchievementService */
    private $service;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Steam::class);
        $this->service = new AchievementService(
            new StatsRepository($this->client),
            new AchievementTransformer(),
            new GameProgressionTransformer()
        );
    }

    /**
     * @dataProvider steamDataProvider
     */
    public function testGetAchievements(GameProgression $expected, string $achievements, string $details): void
    {
        $this->client->method('fetch')->will($this->onConsecutiveCalls($details, $achievements));
        $result = $this->service->getAchievements('1234', '321');

        $this->assertEquals($expected->title, $result->title);
        $this->assertEquals($expected->achievements[0], $result->achievements[0]);
    }

    public function steamDataProvider(): Generator
    {
        $achievements = '{
            "gameName": "Grim Dawn",
            "achievements":[{
                "apiname": "ACH001",
                "achieved": 1,
                "unlocktime": 1546119922,
            }]
        }';

        // http://api.steampowered.com/ISteamUserStats/GetSchemaForGame/v2/?appid=219990&key=X
        $details = '{"game":{"gameName":"","gameVersion":"43","availableGameStats":{"achievements":[{"name":"ACH001","defaultvalue":0,"displayName":"Monster Slayer","hidden":0,"description":"Eradicate 25 Heroic Monsters (marked by a Star).","icon":"https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/219990/89b967769ec85cfe515ec24f131cfea8a5a208c7.jpg","icongray":"https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/219990/94f0586732cbbceb1aa6dcc3835a61e47f38fef5.jpg"}]}}}';

        // http://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v0001/?appid=219990&steamid=76561198109613067&key=X
        $achievements = '{"playerstats":{"steamID":"76561198109613067","gameName":"Grim Dawn","achievements":[{"apiname":"ACH001","achieved":1,"unlocktime":1546119922}],"success":true}}';

        $achievement = new Achievement();
        $achievement->id = 'ACH001';
        $achievement->name = 'Monster Slayer';
        $achievement->description = 'Eradicate 25 Heroic Monsters (marked by a Star).';
        $achievement->icon = 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/219990/89b967769ec85cfe515ec24f131cfea8a5a208c7.jpg';
        $achievement->hidden = false;
        $achievement->achieved = true;

        $expected = new GameProgression();
        $expected->title = 'Grim Dawn';
        $expected->achievements = [$achievement];

        yield [$expected, $achievements, $details];
    }
}
