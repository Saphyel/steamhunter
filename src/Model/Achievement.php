<?php

declare(strict_types=1);

namespace App\Model;

final class Achievement
{
    public string $id;
    public string $name;
    public string $description;
    public string $icon;
    public bool $hidden;
    public bool $achieved;
}
