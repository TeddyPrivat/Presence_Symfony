<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DebutController extends AbstractController
{
    #[Route('/debut', name: 'app_debut')]
    public function index(): Response
    {
        return $this->render('debut/index.html.twig', [
            'controller_name' => 'DebutController',
        ]);
    }
}
