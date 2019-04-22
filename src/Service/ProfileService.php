<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Profile;
use App\Repository\PlayerRepository;
use App\Repository\UserRepository;
use App\Transformer\GameTransformer;
use App\Transformer\ProfileTransformer;

final class ProfileService
{
    /** @var UserRepository */
    private $userRepository;
    /** @var PlayerRepository */
    private $playerRepository;
    /** @var ProfileTransformer */
    private $profileTransformer;
    /** @var GameTransformer */
    private $gameTransformer;

    public function __construct(
        UserRepository $userRepository,
        PlayerRepository $playerRepository,
        ProfileTransformer $profileTransformer,
        GameTransformer $gameTransformer
    ) {
        $this->userRepository = $userRepository;
        $this->playerRepository = $playerRepository;
        $this->profileTransformer = $profileTransformer;
        $this->gameTransformer = $gameTransformer;
    }

    public function getUserId(string $username): string
    {
        return $this->userRepository->findUserId($username);
    }

    public function getProfile(string $userId): Profile
    {
        $summary = $this->userRepository->findSummary($userId);
        $summary['games'] = $this->gameList($this->playerRepository->findGames($userId));

        return $this->profileTransformer->transform($summary);
    }

    private function gameList(array $games): array
    {
        $list = [];
        foreach ($games as $game) {
            $list[] = $this->gameTransformer->transform($game);
        }

        return $list;
    }
}
