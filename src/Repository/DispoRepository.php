<?php

namespace App\Repository;

use App\Entity\Dispo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Dispo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dispo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dispo[]    findAll()
 * @method Dispo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DispoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Dispo::class);
    }

    // /**
    //  * @return Dispo[] Returns an array of Dispo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dispo
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
