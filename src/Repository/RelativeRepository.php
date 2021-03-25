<?php

namespace App\Repository;

use App\Entity\Relative;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Relative|null find($id, $lockMode = null, $lockVersion = null)
 * @method Relative|null findOneBy(array $criteria, array $orderBy = null)
 * @method Relative[]    findAll()
 * @method Relative[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelativeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Relative::class);
    }

    // TODO : Check if undestood
    // Create a query : what parameters will be used to question the database
    public function queryAllByUser($userId): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('relative');

        $queryBuilder->where(
            $queryBuilder->expr()->eq('relative.createdBy', $userId)
        );
        $queryBuilder->addOrderBy('relative.firstname', 'asc');

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
