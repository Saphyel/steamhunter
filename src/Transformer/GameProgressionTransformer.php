<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Model\GameProgression;

final class GameProgressionTransformer implements TransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): GameProgression
    {
        $object = new GameProgression();
        $object->title = $data['title'];
        $object->achievements = $data['achievements'];

        return $object;
    }
}
