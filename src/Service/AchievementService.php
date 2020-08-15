<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\GameProgression;
use App\Repository\StatsRepository;
use App\Transformer\AchievementTransformer;
use App\Transformer\GameProgressionTransformer;

final class AchievementService
{
    private StatsRepository $repository;
    private AchievementTransformer $achievementTransformer;
    private GameProgressionTransformer $progressionTransformer;

    public function __construct(
        StatsRepository $repository,
        AchievementTransformer $achievementTransformer,
        GameProgressionTransformer $progressionTransformer
    ) {
        $this->repository = $repository;
        $this->achievementTransformer = $achievementTransformer;
        $this->progressionTransformer = $progressionTransformer;
    }

    public function getAchievements(string $userId, string $appId): GameProgression
    {
        $progression = $this->repository->findAchievements($userId, $appId);
        $details = $this->repository->findGameDetails($appId);
        $list = [];
        $i = 0;
        foreach ($details as $detail) {
            $detail['achieved'] = $progression['achievements'][$i]['achieved'];
            $list[] = $this->achievementTransformer->transform($detail);
            ++$i;
        }

        return $this->progressionTransformer->transform(['title' => $progression['gameName'], 'achievements' => $list]);
    }
}
