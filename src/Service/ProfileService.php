<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\NotFoundException;
use App\Model\Game;
use App\Model\Profile;
use App\Repository\PlayerRepository;
use App\Repository\UserRepository;
use App\Transformer\GameTransformer;
use App\Transformer\ProfileTransformer;

final class ProfileService
{
    private UserRepository $userRepository;
    private PlayerRepository $playerRepository;
    private ProfileTransformer $profileTransformer;
    private GameTransformer $gameTransformer;

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
        $response = $this->userRepository->findUserId($username);

        if (1 !== $response['success']) {
            throw new NotFoundException('No results.');
        }

        return $response['steamid'];
    }

    public function getProfile(string $userId): Profile
    {
        $summary = $this->userRepository->findSummary($userId);
        $summary['games'] = $this->gameList($this->playerRepository->findGames($userId));

        return $this->profileTransformer->transform($summary);
    }

    /**
     * @param mixed[] $games
     *
     * @return Game[]
     */
    private function gameList(array $games): array
    {
        $list = [];
        foreach ($games as $game) {
            $list[] = $this->gameTransformer->transform($game);
        }

        return $list;
    }
}
