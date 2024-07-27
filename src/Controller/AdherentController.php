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
    public function index(AdherentRepository $ar, Request $requete): Response
    {
        $rechercheRecherche = $requete->query->get('recherche');
        $nbRecherche = $requete->query->get('recherche');
        $recherche = $ar->rechercheListe($rechercheRecherche);
        $nbPersonnes = $ar->nbRequete($nbRecherche);
        return $this->render('adherent/listeAdherents.html.twig', [
            'adherents' => $recherche,
            'nbListe' => $nbPersonnes
        ]);
    }

    #[Route('/ajoutAdherent', name: 'app_ajouter_adherent')]
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
            'form' => $form->createView()
        ]);
    }

    #[Route('/supprimerAdherent/{id}', name:'app_supprimer_adherent')]
    public function supprimerAdherent(int $id, EntityManagerInterface $em, AdherentRepository $ar):Response
    {
        $adherent = $ar->find($id);
        $em->remove($adherent);
        $em->flush();
        $this->addFlash('success', 'L\'adhérent a bien été supprimé.');
        return $this->redirectToRoute('app_liste');
    }
}
