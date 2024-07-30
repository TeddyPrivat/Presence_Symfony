<?php

namespace App\Services;



class CalculAge
{
    public function calculAge(\DateTimeImmutable $dateDeNaissance):int
    {
        $dateAujourdhui = new \DateTimeImmutable();
        return $dateAujourdhui->diff($dateDeNaissance)->y;
    }
}