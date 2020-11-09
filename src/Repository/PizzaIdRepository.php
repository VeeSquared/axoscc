<?php

namespace App\Repository;

use App\Entity\PizzaId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PizzaId|null find($id, $lockMode = null, $lockVersion = null)
 * @method PizzaId|null findOneBy(array $criteria, array $orderBy = null)
 * @method PizzaId[]    findAll()
 * @method PizzaId[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PizzaIdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PizzaId::class);
    }

    // /**
    //  * @return PizzaId[] Returns an array of PizzaId objects
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
    public function findOneBySomeField($value): ?PizzaId
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
