<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */

    public function findAllVisible(): array
    {
        return $this->findVisibleQuery()
             ->getQuery()
             ->getResult();
    }

    public function findLatest($limit): array
    {
        return $this->findVisibleQuery()
              ->setMaxResults ($limit)
              ->getQuery()
              ->getResult();
    }

    public function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }

    public function findAllRentQuery(PropertySearch $search): Query
    {
        $query = $this->findRentQuery();

        if ($search->getTitleS())
        {
            $query = $query
                ->andWhere('p.title LIKE :titles ')
                ->setParameter('titles', '%'.$search->getTitleS().'%');
        }
        
        if ($search->getPropertyId())
        {
            $query = $query
                ->andWhere('p.id = :propertyid')
                ->setParameter('propertyid', $search->getPropertyId());
        }

        if ($search->getSituationS())
        {
            $query = $query
                ->andWhere('p.situation = :situations')
                ->setParameter('situations', $search->getSituationS());
        }

        if ($search->getTypeS())
        {
            $query = $query
                ->andWhere('p.type = :types')
                ->setParameter('types', $search->getTypeS());
        }

        if ($search->getStateS())
        {
            $query = $query
                ->andWhere('p.state = :states')
                ->setParameter('states', $search->getStateS());
        }

        if ($search->getMinSpace())
        {
            $query = $query
                ->andWhere('p.space >= :minspace')
                ->setParameter('minspace', $search->getMinSpace());
        }

        if ($search->getMinRooms())
        {
            $query = $query
                ->andWhere('p.rooms >= :minrooms')
                ->setParameter('minrooms', $search->getMinRooms());
        }

        if ($search->getMinBedrooms())
        {
            $query = $query
                ->andWhere('p.bedrooms >= :minbedrooms')
                ->setParameter('minbedrooms', $search->getMinBedrooms());
        }

        if ($search->getMaxPrice())
        {
            $query = $query
                ->andWhere('p.price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }

        return $query->getQuery();
            
    }

    public function findAllQuery(PropertySearch $search): Query
    {
        $query = $this->findVisibleQuery();

        if ($search->getTitleS())
        {
            $query = $query
                ->andWhere('p.title LIKE :titles ')
                ->setParameter('titles', '%'.$search->getTitleS().'%');
        }

        if ($search->getLat() && $search->getLng() && $search->getDistance())
        {
            $query = $query
                ->select('p')
                ->andWhere('(6353 * 2 * ASIN(SQRT( POWER(SIN((p.lat - :lat) * pi()/180 / 2), 2) +COS(p.lat * pi()/180) * COS(:lat * pi()/180) * POWER(SIN((p.lng - :lng) * pi()/180 / 2), 2) ))) <= :distance')
                ->setParameter('lng', $search->getLng())
                ->setParameter('lat', $search->getLat())
                ->setParameter('distance', $search->getDistance());
                
        }

        if ($search->getPropertyId())
        {
            $query = $query
                ->andWhere('p.id = :propertyid')
                ->setParameter('propertyid', $search->getPropertyId());
        }

        if ($search->getSituationS())
        {
            $query = $query
                ->andWhere('p.situation = :situations')
                ->setParameter('situations', $search->getSituationS());
        }

        if ($search->getTypeS())
        {
            $query = $query
                ->andWhere('p.type = :types')
                ->setParameter('types', $search->getTypeS());
        }

        if ($search->getStateS())
        {
            $query = $query
                ->andWhere('p.state = :states')
                ->setParameter('states', $search->getStateS());
        }

        if ($search->getMinSpace())
        {
            $query = $query
                ->andWhere('p.space >= :minspace')
                ->setParameter('minspace', $search->getMinSpace());
        }

        if ($search->getMinRooms())
        {
            $query = $query
                ->andWhere('p.rooms >= :minrooms')
                ->setParameter('minrooms', $search->getMinRooms());
        }

        if ($search->getMinBedrooms())
        {
            $query = $query
                ->andWhere('p.bedrooms >= :minbedrooms')
                ->setParameter('minbedrooms', $search->getMinBedrooms());
        }

        if ($search->getMaxPrice())
        {
            $query = $query
                ->andWhere('p.price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }

        return $query->getQuery();
            
    }

    public function findRentQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.situation = 2');
    }

    public function findAllSellQuery(PropertySearch $search): Query
    {
        $query = $this->findSellQuery();

        if ($search->getPropertyId())
        {
            $query = $query
                ->andWhere('p.id = :propertyid')
                ->setParameter('propertyid', $search->getPropertyId());
        }

        if ($search->getSituationS())
        {
            $query = $query
                ->andWhere('p.situation = :situations')
                ->setParameter('situations', $search->getSituationS());
        }

        if ($search->getTypeS())
        {
            $query = $query
                ->andWhere('p.type = :types')
                ->setParameter('types', $search->getTypeS());
        }

        if ($search->getStateS())
        {
            $query = $query
                ->andWhere('p.state = :states')
                ->setParameter('states', $search->getStateS());
        }

        if ($search->getMinSpace())
        {
            $query = $query
                ->andWhere('p.space >= :minspace')
                ->setParameter('minspace', $search->getMinSpace());
        }

        if ($search->getMinRooms())
        {
            $query = $query
                ->andWhere('p.rooms >= :minrooms')
                ->setParameter('minrooms', $search->getMinRooms());
        }

        if ($search->getMinBedrooms())
        {
            $query = $query
                ->andWhere('p.bedrooms >= :minbedrooms')
                ->setParameter('minbedrooms', $search->getMinBedrooms());
        }

        if ($search->getMaxPrice())
        {
            $query = $query
                ->andWhere('p.price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }

        return $query->getQuery();
             
    }

    public function findSellQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.situation = 1');
    }

    public function findAllSold(): array
    {
        return $this->findSoldQuery()
             ->getQuery()
             ->getResult();
    }

    public function findSoldQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.situation = 0');
    }

    
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

    /*
    public function findOneBySomeField($value): ?Property
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

