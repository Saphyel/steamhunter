<?php

declare(strict_types=1);

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    /**
     * @Cache(smaxage="1 day", mustRevalidate=true)
     * @Route("/", methods={"GET"})
     * @Template
     */
    public function index(): void
    {
    }

    /**
     * @Route("/", methods={"POST"})
     * @Template
     */
    public function send(Request $request): Response
    {
        return $this->redirectToRoute('app_steam_profile', ['name' => $request->get('name', '')]);
    }
}
