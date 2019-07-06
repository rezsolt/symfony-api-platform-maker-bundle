<?php

namespace App\Repository;

use App\Entity\SecondBar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SecondBar|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecondBar|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecondBar[]    findAll()
 * @method SecondBar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecondBarRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SecondBar::class);
    }

    // /**
    //  * @return SecondBar[] Returns an array of SecondBar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SecondBar
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
