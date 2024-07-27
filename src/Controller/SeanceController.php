<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Form\SeanceType;
use App\Repository\SeanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use IntlDateFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SeanceController extends AbstractController
{
    #[Route('/creerSeance', name: 'creer_seance')]
    public function creerSeance(Request $request, EntityManagerInterface $em):Response
    {
        $seance = new Seance();
        $formSeance = $this->createForm(SeanceType::class, $seance);
        $formSeance->handleRequest($request);
        if($formSeance->isSubmitted()){
            dump($seance->getDate());
        }
        if($formSeance->isSubmitted() && $formSeance->isValid()){

            $em->persist($seance);
            $em->flush();
            $this->addFlash('success', 'La séance a bien été créée.');
            return $this->redirectToRoute('liste_seance');
        }
        return $this->render('seance/index.html.twig', [
            'formSeance' => $formSeance->createView(),
        ]);
    }

    #[Route('/listeSeance', name: 'liste_seance')]
    public function listeSeance(SeanceRepository $sr):Response
    {
        $seancesDansLOrdre = $sr->findAllOrderedByDateDesc();
        return $this->render('seance/liste_seance.html.twig', [
            'seances' => $seancesDansLOrdre
        ]);
    }

    #[Route('/detailsSeance/{id}', name:'details_seance')]
    public function detailsSeance(int $id, SeanceRepository $sr):Response
    {
        $seance = $sr->find($id);
        return $this->render('seance/details_seance.html.twig', [
            'seance' => $seance,
        ]);
    }

    #[Route('/supprimerSeance/{id}', name:'supprimer_seance')]
    public function supprimerSeance(int $id, SeanceRepository $sr, EntityManagerInterface $em):Response
    {
        $seanceASupprimer = $sr->find($id);
        $em->remove($seanceASupprimer);
        $em->flush();
        $this->addFlash('success', 'La séance a bien été supprimée.');
        return $this->redirectToRoute('liste_seance');
    }

    #[Route('/modifierSeance/{id}', name:'modifier_seance')]
    public function modifierSeance(int $id, EntityManagerInterface $em, SeanceRepository $sr,  Request $request):Response
    {
        $seanceAModifier = $sr->find($id);
        $form = $this->createForm(SeanceType::class, $seanceAModifier);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($seanceAModifier);
            $em->flush();
            $this->addFlash('success','La séance a bien été modifiée');
            return $this->redirectToRoute('liste_seance');
        }
        return $this->render('seance/modifier_seance.html.twig',[
            'seanceAModifier' => $seanceAModifier,
            'formSeance' => $form->createView()
        ]);
    }
}
