<?php

namespace App\Repository;

use App\Entity\Concours;
use App\Entity\Phase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Phase>
 *
 * @method Phase|null find($id, $lockMode = null, $lockVersion = null)
 * @method Phase|null findOneBy(array $criteria, array $orderBy = null)
 * @method Phase[]    findAll()
 * @method Phase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Phase::class);
    }

 

    public function getList(Concours $concours):array
    {
        $qb = $this->createQueryBuilder('a')
                   ->Where('a.concours = :concours')
                   // ->setParameter('now', new \DateTime())
                    //->setParameter('provider', $p)
                    ->setParameter('concours', $concours->getId())
                    ->orderBy('a.id', 'DESC') ;
        return $qb->getQuery()->getResult();
        // return (new Paginator($qb))->paginate($page);
    }
//    /**
//     * @return Phase[] Returns an array of Phase objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Phase
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
