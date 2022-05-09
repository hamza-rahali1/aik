<?php

namespace App\Repository;

use App\Entity\Testimanial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Testimanial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Testimanial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Testimanial[]    findAll()
 * @method Testimanial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestimanialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Testimanial::class);
    }

    // /**
    //  * @return Testimanial[] Returns an array of Testimanial objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Testimanial
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}