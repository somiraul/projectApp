<?php

namespace App\Repository;

use App\Entity\TestImageUploadResized;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TestImageUploadResized|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestImageUploadResized|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestImageUploadResized[]    findAll()
 * @method TestImageUploadResized[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestImageUploadResizedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TestImageUploadResized::class);
    }

    // /**
    //  * @return TestImageUploadResized[] Returns an array of TestImageUploadResized objects
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
    public function findOneBySomeField($value): ?TestImageUploadResized
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
