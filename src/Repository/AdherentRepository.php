<?php

namespace App\Repository;

use App\Entity\Adherent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Adherent>
 */
class AdherentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adherent::class);
    }

    //    /**
    //     * @return Adherent[] Returns an array of Adherent objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Adherent
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function rechercheListe($recherche):array
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT a.nom, a.prenom, a.age, a.ceinture
            FROM App\Entity\Adherent a
            WHERE(
                a.nom LIKE :terme
                OR a.prenom LIKE :terme
                OR a.age = :rechercheAge
                OR a.ceinture = :ceinture
            )
        ')
        ->setParameter('terme', '%'.$recherche.'%')
        ->setParameter('rechercheAge', $recherche)
        ->setParameter('ceinture', $recherche);
        return $query->getResult();
    }

    public function nbRequete($recherche):int
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT COUNT(a.nom)
            FROM App\Entity\Adherent a
            WHERE(
                a.nom LIKE :terme
                OR a.prenom LIKE :terme
                OR a.age = :rechercheAge
                OR a.ceinture = :ceinture
            )
        ')
            ->setParameter('terme', '%'.$recherche.'%')
            ->setParameter('rechercheAge', $recherche)
            ->setParameter('ceinture', $recherche);
        return $query->getSingleScalarResult();
    }
}
