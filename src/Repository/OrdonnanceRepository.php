<?php

namespace App\Repository;

use App\Entity\Depenses;
use App\Entity\Ordonnance;
use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ordonnance>
 *
 * @method Ordonnance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ordonnance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ordonnance[]    findAll()
 * @method Ordonnance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdonnanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ordonnance::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Ordonnance $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Ordonnance $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Patient[] Returns an array of Patient objects
     */
    public function getPriceToDay()
    {
        $date = new \DateTime("now");
        return $this->createQueryBuilder('o')
            ->select('SUM(o.prixFinal)')
            ->andWhere("o.dateORD >= :dateStart")
            ->andWhere("o.dateORD <= :dateEnd")
            ->setParameter('dateStart', $date->format('Y-m-d 00:00:00'))
            ->setParameter('dateEnd', $date->format('Y-m-d 23:59:59'))
            ->getQuery()
            ->getScalarResult()
        ;
    }

    /**
     *
     * SELECT DATE_FORMAT(date_ord,'%Y %M %D') AS date_, SUM(prix_final) AS pr FROM `ordonnance`
    WHERE DATE_FORMAT(date_ord,'%y %m %d') >= DATE_FORMAT(CURRENT_DATE()-7,'%y %m %d')
    GROUP BY date_;
     */


    /**
     * @return Patient[] Returns an array of Patient objects
     */
    public function getPriceWeekly()
    {
        $date = new \DateTime("now");
        return $this->createQueryBuilder('o')
            ->select("o.dateORD, SUM(o.prixFinal) AS pr")
            ->andWhere("o.dateORD >= :date")
            ->setParameter('date', date('Y-m-d', strtotime('-7 days')))
            ->groupBy("o.dateORD")
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Ordonnance[] Returns an array of Ordonnance objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ordonnance
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
