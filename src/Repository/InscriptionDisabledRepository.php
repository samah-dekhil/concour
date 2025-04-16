<?php

namespace App\Repository;

use App\Entity\InscriptionDisabled;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InscriptionDisabled>
 *
 * @method InscriptionDisabled|null find($id, $lockMode = null, $lockVersion = null)
 * @method InscriptionDisabled|null findOneBy(array $criteria, array $orderBy = null)
 * @method InscriptionDisabled[]    findAll()
 * @method InscriptionDisabled[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionDisabledRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InscriptionDisabled::class);
    }

//    /**
//     * @return InscriptionDisabled[] Returns an array of InscriptionDisabled objects
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

//    public function findOneBySomeField($value): ?InscriptionDisabled
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
