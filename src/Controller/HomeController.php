<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    /**
     * @Route("/", methods={"POST"})
     */
    public function send(Request $request): Response
    {
        return $this->redirectToRoute('app_steam_profile', ['name' => $request->get('name', '')]);
    }
}
