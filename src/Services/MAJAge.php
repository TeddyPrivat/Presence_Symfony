<?php

namespace App\Services;


use App\Repository\AdherentRepository;
use Doctrine\ORM\EntityManagerInterface;

class MAJAge
{
    public function majAge(AdherentRepository $ar, EntityManagerInterface $em, CalculAge $ca): void
    {
        $adherents = $ar->findAll();
        foreach ($adherents as $adherent){
           if($ca->calculAge($adherent->getDateDeNaissance()) != $adherent->getAge()){
               $adherent->setAge($ca->calculAge($adherent->getDateDeNaissance()));
               $em->persist($adherent);
           }
        }
        $em->flush();
    }
}