<?php

namespace App\Repository;

use App\Entity\TestCrudEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TestCrudEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestCrudEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestCrudEntity[]    findAll()
 * @method TestCrudEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestCrudEntityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TestCrudEntity::class);
    }

    // /**
    //  * @return TestCrudEntity[] Returns an array of TestCrudEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TestCrudEntity
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
