<?php

namespace App\Repository;

use App\Entity\FirstFoo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FirstFoo|null find($id, $lockMode = null, $lockVersion = null)
 * @method FirstFoo|null findOneBy(array $criteria, array $orderBy = null)
 * @method FirstFoo[]    findAll()
 * @method FirstFoo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FirstFooRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FirstFoo::class);
    }

    // /**
    //  * @return FirstFoo[] Returns an array of FirstFoo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FirstFoo
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
