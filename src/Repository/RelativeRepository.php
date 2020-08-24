<?php

namespace App\Repository;

use App\Entity\Relative;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function findAllOrderedByFirstName()
    {
        // je crée "l'usine" à requete
        $queryBuilder = $this->createQueryBuilder('relative');

        // fabrique une requete personnalisée
        $queryBuilder->orderBy('relative.firstname', 'asc');

        // a la fin je recupère a la requete fabriquée
        $query = $queryBuilder->getQuery();

        // j'execute la requete pour en recupérer les resultats
        // getResult me renvoi une LISTE des resultats 
        return $query->getResult();
    }
}
