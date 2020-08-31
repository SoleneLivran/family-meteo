<?php

namespace App\Repository;

use App\Entity\Home;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Home|null find($id, $lockMode = null, $lockVersion = null)
 * @method Home|null findOneBy(array $criteria, array $orderBy = null)
 * @method Home[]    findAll()
 * @method Home[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Home::class);
    }

    public function queryAllByUser($userId): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('home');

        $queryBuilder->where(
            $queryBuilder->expr()->eq('home.createdBy', $userId)
        );

        $queryBuilder->addOrderBy('home.name', 'asc');

        return $queryBuilder;
    }

    public function findAllByUser($userId)
    {
        $queryBuilder = $this->queryAllByUser($userId);

        $query = $queryBuilder->getQuery();

        // me renvoi UN seul resultat 
        return $query->getResult();
    }

    // /**
    //  * @return Home[] Returns an array of Home objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Home
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
