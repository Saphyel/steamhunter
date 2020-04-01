<?php

declare(strict_types=1);

namespace App\Model;

final class Profile
{
    public string $steamId;
    public string $personaName;
    public string $avatar;
    public string $url;
    public string $realName;
    public string $countryCode;
    /** @var Game[] */
    public array $games;
}
