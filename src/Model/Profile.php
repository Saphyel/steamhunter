<?php

declare(strict_types=1);

namespace App\Model;

final class Profile
{
    /** @var string */
    public $steamId;
    /** @var string */
    public $personaName;
    /** @var string */
    public $avatar;
    /** @var string */
    public $url;
    /** @var string */
    public $realName;
    /** @var string */
    public $countryCode;
    /** @var Game[] */
    public $games;
}
