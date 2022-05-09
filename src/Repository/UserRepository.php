<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\User;
use App\Entity\UserSearch;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    public function findAllVisible(): array
    {
        return $this->findVisibleQuery()
             ->getQuery()
             ->getResult();
    }

    public function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('u');
    }

    public function findAllQuery(UserSearch $search): Query
    {
        $query = $this->findVisibleQuery();

        if ($search->getKeyWord())
        {
            $query = $query
                ->andWhere('u.firstName LIKE :keyword OR u.lastName LIKE :keyword OR u.email LIKE :keyword OR u.otherEmail LIKE :keyword')
                ->setParameter('keyword', '%'.$search->getKeyWord().'%');
        }

        if ($search->getId())
        {
            $query = $query
                ->andWhere('u.id = :id')
                ->setParameter('id', $search->getId());
        }

        if ($search->getPhone())
        {
            $query = $query
                ->andWhere('(u.phone LIKE :phone ')
                ->setParameter('phone', '%'.$search->getPhone().'%');
        }

        if ($search->getFax())
        {
            $query = $query
                ->andWhere('(u.fax LIKE :fax ')
                ->setParameter('fax', '%'.$search->getFax().'%');
        }

        if ($search->getRoles())
        {
            $query = $query
                ->andWhere('u.roles = :roles')
                ->setParameter('roles', $search->getRoles());
        }
                


        return $query->getQuery();
            
    }

    public function findAllMessageQuery(): Query
    {
        $query = $this->findVisibleQuery();
                
        return $query->getQuery();
            
    }

    public function findAikMail($id): array
    {
        $query = $this->findVisibleQuery();
        $query = $query
                ->andWhere('u.id = :id')
                ->setParameter('id', $id)
                ->getQuery();

        return $query->getResult();
    }
}
