<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Form\AjoutAdherentType;
use App\Form\PromotionType;
use App\Repository\AdherentRepository;
use App\Services\Age;
use App\Services\CalculAge;
use App\Services\MAJAge;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdherentController extends AbstractController
{
    #[Route('/liste', name: 'app_liste')]
    public function index(AdherentRepository $ar, Request $requete, MAJAge $ma, EntityManagerInterface $em, CalculAge $ca): Response
    {
        $ma->majAge($ar, $em, $ca);
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
    public function creerAdherent(Request $request, EntityManagerInterface $em, CalculAge $ca):Response
    {
        $adherent = new Adherent();
        $form = $this->createForm(AjoutAdherentType::class, $adherent);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $adherent->setAge($ca->calculAge($adherent->getDateDeNaissance()));
            dump($adherent->getAge());
            $em->persist($adherent);
            $em->flush();
            $this->addFlash('success', 'L\'adhérent(e) '.$adherent->getPrenom().' '.$adherent->getNom().' a bien été ajouté(e).');
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
        $this->addFlash('success', 'L\'adhérent(e) a bien été supprimé(e).');
        return $this->redirectToRoute('app_liste');
    }

    #[Route('/modifierAdherent/{id}', name: 'app_modifier_adherent')]
    public function promotionAdherent(int $id, EntityManagerInterface $em, AdherentRepository $ar, Request $request):Response
    {
        $adherent = $ar->find($id);
        $formPromotion = $this->createForm(AjoutAdherentType::class, $adherent);
        $formPromotion->handleRequest($request);
        if($formPromotion->isSubmitted() && $formPromotion->isValid()){
            $em->persist($adherent);
            $em->flush();
            $this->addFlash('success', $adherent->getPrenom().' '.$adherent->getNom(). ' a été modifié(e).');
            return $this->redirectToRoute('app_liste');
        }
        return $this->render('adherent/modifierAdherent.html.twig',[
                'formPromotion' => $formPromotion->createView(),
                'adherent' => $adherent
            ]);

    }
}
