<?php

namespace App\Repository;

use App\Entity\InscriptionConvocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InscriptionConvocation>
 *
 * @method InscriptionConvocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method InscriptionConvocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method InscriptionConvocation[]    findAll()
 * @method InscriptionConvocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionConvocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InscriptionConvocation::class);
    }

//    /**
//     * @return InscriptionConvocation[] Returns an array of InscriptionConvocation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InscriptionConvocation
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
