<?php

namespace App\Repository;

use App\Entity\PrePayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PrePayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrePayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrePayment[]    findAll()
 * @method PrePayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrePaymentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PrePayment::class);
    }

    // /**
    //  * @return PrePayment[] Returns an array of PrePayment objects
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
    public function findOneBySomeField($value): ?PrePayment
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
