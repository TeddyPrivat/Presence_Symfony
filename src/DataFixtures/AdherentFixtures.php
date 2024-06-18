<?php

namespace App\DataFixtures;

use App\Entity\Adherent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdherentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $adherent = new Adherent();
        $adherent->setNom('Privat');
        $adherent->setPrenom('Teddy');
        $adherent->setAge(21);
        $adherent->setCeinture('Bleue');
        $manager->persist($adherent);
        $manager->flush();
    }
}
