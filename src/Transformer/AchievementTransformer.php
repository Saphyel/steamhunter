<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Model\Achievement;
use function array_key_exists;

final class AchievementTransformer implements TransformerInterface
{
    public function transform($data)
    {
        $object = new Achievement();
        $object->id = $data['name'];
        $object->name = $data['displayName'];
        $object->icon = $data['icon'];
        $object->hidden = $data['hidden'];
        $object->achieved = $data['achieved'];

        if (array_key_exists('description', $data)) {
            $object->description = $data['description'];
        }

        return $object;
    }
}