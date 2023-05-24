<?php

namespace App\Repository;

use App\Entity\EffektAvCovid19;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EffektAvCovid19>
 *
 * @method EffektAvCovid19|null find($id, $lockMode = null, $lockVersion = null)
 * @method EffektAvCovid19|null findOneBy(array $criteria, array $orderBy = null)
 * @method EffektAvCovid19[]    findAll()
 * @method EffektAvCovid19[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EffektAvCovid19Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EffektAvCovid19::class);
    }

    public function save(EffektAvCovid19 $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EffektAvCovid19 $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EffektAvCovid19[] Returns an array of EffektAvCovid19 objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EffektAvCovid19
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
