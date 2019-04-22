<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Model\Game;

final class GameTransformer implements TransformerInterface
{
    public function transform($data)
    {
        $object = new Game();
        $object->id = $data['appid'];
        $object->name = $data['name'];
        $object->logo = $data['img_logo_url'];
        $object->played = $data['playtime_forever'];

        return $object;
    }
}
