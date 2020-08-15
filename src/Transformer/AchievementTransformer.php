<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Model\Achievement;
use function array_key_exists;

final class AchievementTransformer implements TransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): Achievement
    {
        $object = new Achievement();
        $object->id = $data['name'];
        $object->name = $data['displayName'];
        $object->icon = $data['icon'];
        $object->hidden = (bool) $data['hidden'];
        $object->achieved = (bool) $data['achieved'];

        if (array_key_exists('description', $data)) {
            $object->description = $data['description'];
        }

        return $object;
    }
}
