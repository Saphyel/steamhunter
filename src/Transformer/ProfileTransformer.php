<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Model\Profile;

final class ProfileTransformer implements TransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): Profile
    {
        $object = new Profile();
        $object->steamId = $data['steamid'];
        $object->avatar = $data['avatar'];
        $object->personaName = $data['personaname'];
        $object->realName = $data['realname'];
        $object->url = $data['profileurl'];
        $object->countryCode = $data['loccountrycode'];
        $object->games = $data['games'];

        return $object;
    }
}
