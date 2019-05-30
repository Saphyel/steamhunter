<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Service\AchievementService;
use App\Service\ProfileService;
use Psr\Cache\CacheItemPoolInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Cache(smaxage="86400", maxage="86400")
 */
final class SteamController extends AbstractController
{
    /** @var CacheItemPoolInterface */
    private $cache;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @Route("/{name}", methods={"GET"})
     */
    public function profile(string $name, ProfileService $service): Response
    {
        try {
            $item = $this->cache->getItem('profile_'.md5($name));
            if (!$item->isHit()) {
                $item->set($service->getProfile($service->getUserId($name)));
                $this->cache->save($item);
            }
        } catch (NotFoundException $exception) {
            throw $this->createNotFoundException($exception->getMessage());
        }

        return $this->render(
            'steam/profile.html.twig',
            $this->container->get('serializer')->normalize($item->get())
        );
    }

    /**
     * @Route("/{steamId}/{appId}", methods={"GET"})
     */
    public function achievements(string $steamId, string $appId, AchievementService $service): Response
    {
        try {
            $item = $this->cache->getItem('achievements_'.md5($steamId).'_'.md5($appId));
            if (!$item->isHit()) {
                $item->set($service->getAchievements($steamId, $appId));
                $this->cache->save($item);
            }
        } catch (TransportException $exception) {
            throw $this->createNotFoundException('Requested app has no stats.');
        }

        return $this->render(
            'steam/achievements.html.twig',
            $this->container->get('serializer')->normalize($item->get())
        );
    }
}
