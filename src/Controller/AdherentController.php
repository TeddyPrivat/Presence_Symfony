<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Form\AjoutAdherentType;
use App\Repository\AdherentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdherentController extends AbstractController
{
    #[Route('/liste', name: 'app_liste')]
    public function index(AdherentRepository $ar): Response
    {
        $adherents = $ar->findAll();
        return $this->render('adherent/index.html.twig', [
            'adherents' => $adherents,
        ]);
    }

    #[Route('/creerAdherent', name: 'app_creer_adherent')]
    public function creerAdherent(Request $request, EntityManagerInterface $em):Response
    {
        $adherent = new Adherent();
        $form = $this->createForm(AjoutAdherentType::class, $adherent);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($adherent);
            $em->flush();
            $this->addFlash('success', 'L\'adhérent a bien été ajouté.');
            return $this->redirectToRoute('app_liste');
        }
        return $this->render('adherent/ajoutAdherent.html.twig',[
            'form' => $form
        ]);
    }
}
