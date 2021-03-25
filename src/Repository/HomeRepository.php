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

    // TODO : Check if undestood
    // Create a query : what parameters will be used to question the database
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
        // prepare the previously constructed query
        $queryBuilder = $this->queryAllByUser($userId);

        // retrieve the constructed query in $query
        $query = $queryBuilder->getQuery();

        // execute the query and get results
        // getResult sends a list of results
        return $query->getResult();
    }
}
