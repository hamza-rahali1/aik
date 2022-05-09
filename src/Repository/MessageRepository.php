<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Message;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findAllVisible(): array
    {
        return $this->findVisibleQuery()
             ->getQuery()
             ->getResult();
    }

    public function findLatest(User $user): array
    {
        $query = $this->findVisibleQuery();

            $query = $query
                ->andWhere('m.destination = :destination ')
                ->setParameter('destination', $user);
        
        return $query->getQuery()
              ->getResult();

    }

    public function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('m');
    }


    public function findAllMessageQuery(User $user): Query
    {
        $query = $this->findVisibleQuery();

            $query = $query
                ->andWhere('m.destination = :destination ')
                ->setParameter('destination', $user);
     
            $query = $query
                ->orWhere('m.author = :author')
                ->setParameter('author', $user);

            return $query->getQuery();
    }

    // /**
    //  * @return Message[] Returns an array of Message objects
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
    public function findOneBySomeField($value): ?Message
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