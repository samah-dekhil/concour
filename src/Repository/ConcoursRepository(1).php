<?php

namespace App\Repository;

use App\Entity\Concours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Concours>
 *
 * @method Concours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concours[]    findAll()
 * @method Concours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concours::class);
    }

    public function save(Concours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Concours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getList()
    {
       return   $this->createQueryBuilder('c')
                ->where('c.dateFinInscription > :param')
                ->setParameter('param', new \DateTime())
                ->orderBy('c.dateCreation', 'ASC')
                ->getQuery()
                ->getResult();
    }
    public function getOne($concours)
    {  //dump($concours);
       return   $this->createQueryBuilder('c')
                ->where('c.dateFinInscription > :param')
                ->andWhere('c.id > :id')
                ->setParameter('param', new \DateTime())
                ->setParameter('id', $concours->getId())
                
                ->getQuery()
                ->getOneOrNullResult();
    }


//    /**
//     * @return Concours[] Returns an array of Concours objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Concours
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
