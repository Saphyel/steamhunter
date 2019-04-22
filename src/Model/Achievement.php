<?php

declare(strict_types=1);

namespace App\Model;

final class Achievement
{
    /** @var string */
    public $id;
    /** @var string */
    public $name;
    /** @var string */
    public $description;
    /** @var string */
    public $icon;
    /** @var bool */
    public $hidden;
    /** @var bool */
    public $achieved;
}
