<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Service\AchievementService;
use App\Service\ProfileService;
use GuzzleHttp\Exception\RequestException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Cache(smaxage="1 day", mustRevalidate=true)
 */
final class SteamController extends AbstractController
{
    /** @var ProfileService */
    private $profileService;
    /** @var AchievementService */
    private $achievementService;

    public function __construct(ProfileService $profileService, AchievementService $achievementService)
    {
        $this->profileService = $profileService;
        $this->achievementService = $achievementService;
    }

    /**
     * @Route("/{name}", methods={"GET"})
     * @Template
     */
    public function profile(string $name): array
    {
        try {
            return $this->container->get('serializer')->normalize(
                $this->profileService->getProfile($this->profileService->getUserId($name))
            );
        } catch (NotFoundException $exception) {
            throw $this->createNotFoundException($exception->getMessage());
        }
    }

    /**
     * @Route("/{steamId}/{appId}", methods={"GET"})
     * @Template
     */
    public function achievements(string $steamId, string $appId): array
    {
        try {
            return $this->container->get('serializer')->normalize(
                $this->achievementService->getAchievements($steamId, $appId)
            );
        } catch (RequestException $exception) {
            throw $this->createNotFoundException('Requested app has no stats.');
        }
    }
}
