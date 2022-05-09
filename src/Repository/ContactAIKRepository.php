<?php

namespace App\Repository;

use App\Entity\ContactAIK;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContactAIK|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactAIK|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactAIK[]    findAll()
 * @method ContactAIK[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactAIKRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactAIK::class);
    }

    // /**
    //  * @return ContactAIK[] Returns an array of ContactAIK objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContactAIK
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
