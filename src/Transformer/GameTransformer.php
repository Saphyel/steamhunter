<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Model\Game;

final class GameTransformer implements TransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): Game
    {
        $object = new Game();
        $object->id = $data['appid'];
        $object->name = $data['name'];
        if (!empty($data['img_logo_url'])) {
            $object->logo = $data['img_logo_url'];
        }
        $object->played = $data['playtime_forever'];

        return $object;
    }
}
