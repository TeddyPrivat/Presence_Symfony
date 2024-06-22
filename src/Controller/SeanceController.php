<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Form\SeanceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SeanceController extends AbstractController
{
    #[Route('/seance', name: 'app_seance')]
    public function index(): Response
    {
        return $this->render('seance/index.html.twig', [
            'controller_name' => 'SeanceController',
        ]);
    }

    #[Route('/creerSeance', name: 'creer_seance')]
    public function creerSeance(Request $request, EntityManagerInterface $em):Response
    {
        $seance = new Seance();
        $formSeance = $this->createForm(SeanceType::class, $seance);
        $formSeance->handleRequest($request);
        if($formSeance->isSubmitted() && $formSeance->isValid()){
            $em->persist($seance);
            $em->flush();
            $this->addFlash('success', 'L\'adhérent a bien été ajouté.');
            return $this->redirectToRoute('creer_seance');
        }
        return $this->render('seance/index.html.twig', [
            'formSeance' => $formSeance->createView(),
        ]);
    }
}
