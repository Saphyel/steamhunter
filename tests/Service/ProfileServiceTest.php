<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Exception\NotFoundException;
use App\Http\Steam;
use App\Model\Game;
use App\Model\Profile;
use App\Repository\PlayerRepository;
use App\Repository\UserRepository;
use App\Service\ProfileService;
use App\Transformer\GameTransformer;
use App\Transformer\ProfileTransformer;
use Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ProfileServiceTest extends TestCase
{
    /** @var MockObject&Steam */
    private $client;
    /** @var ProfileService */
    private $service;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Steam::class);
        $this->service = new ProfileService(
            new UserRepository($this->client),
            new PlayerRepository($this->client),
            new ProfileTransformer(),
            new GameTransformer()
        );
    }

    /**
     * @dataProvider idValidDataProvider
     */
    public function testGetUserId(string $expected, string $payload): void
    {
        $this->client->method('fetch')->willReturn($payload);
        $this->assertEquals($expected, $this->service->getUserId('123'));
    }

    /**
     * @dataProvider idInvalidDataProvider
     *
     * @param class-string<\Throwable> $expected
     */
    public function testGetUserIdError(string $expected, string $payload): void
    {
        $this->client->method('fetch')->willReturn($payload);
        $this->expectException($expected);

        $this->service->getUserId('123');
    }

    /**
     * @dataProvider summaryDataProvider
     */
    public function testGetProfile(Profile $expected, string $user, string $player): void
    {
        $this->client->method('fetch')->will($this->onConsecutiveCalls($user, $player));
        $this->assertEquals($expected, $this->service->getProfile('123'));
    }

    /**
     * @return Generator<mixed[]>
     */
    public function summaryDataProvider(): Generator
    {
        // http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/?steamids=76561197960435530&key=X
        $user = '{"response":{"players":[{"steamid":"76561198109613067","communityvisibilitystate":3,"profilestate":1,"personaname":"Saphyel","lastlogoff":1555940419,"profileurl":"https://steamcommunity.com/id/Saphyel/","avatar":"https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/46/464cde033aaa608ede90255f7dd869954aee68a4.jpg","avatarmedium":"https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/46/464cde033aaa608ede90255f7dd869954aee68a4_medium.jpg","avatarfull":"https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/46/464cde033aaa608ede90255f7dd869954aee68a4_full.jpg","personastate":3,"realname":"Carlos","primaryclanid":"103582791429521408","timecreated":1380828090,"personastateflags":0,"loccountrycode":"GB","locstatecode":"17"}]}}';

        // http://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?steamid=76561198109613067&include_appinfo=1&key=X
        $player = '{"response":{"game_count":1,"games":[{"appid":219990,"name":"Grim Dawn","playtime_2weeks":292,"playtime_forever":2354,"img_icon_url":"762057f2b14463ae1cbf0701a4cdb25cf94e8a0c","img_logo_url":"8021ad6119b367593f1b1536aafd11397fb24ae9","has_community_visible_stats":true}]}}';

        $game = new Game();
        $game->id = 219990;
        $game->name = 'Grim Dawn';
        $game->logo = '8021ad6119b367593f1b1536aafd11397fb24ae9';
        $game->played = 2354;

        $expected = new Profile();
        $expected->steamId = '76561198109613067';
        $expected->avatar = 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/46/464cde033aaa608ede90255f7dd869954aee68a4.jpg';
        $expected->personaName = 'Saphyel';
        $expected->realName = 'Carlos';
        $expected->url = 'https://steamcommunity.com/id/Saphyel/';
        $expected->countryCode = 'GB';
        $expected->games = [$game];

        yield [$expected, $user, $player];
    }

    /**
     * @return Generator<string[]>
     */
    public function idValidDataProvider(): Generator
    {
        // http://api.steampowered.com/ISteamUser/ResolveVanityURL/v1/?vanityurl=Saphyel&key=X
        yield ['76561198109613067', '{"response":{"steamid":"76561198109613067","success":1}}'];
    }

    /**
     * @return Generator<string[]>
     */
    public function idInvalidDataProvider(): Generator
    {
        // http://api.steampowered.com/ISteamUser/ResolveVanityURL/v1/?vanityurl=Saphyel&key=X
        yield [NotFoundException::class, '{"response":{"success":42,"message":"No match"}}'];
    }
}
