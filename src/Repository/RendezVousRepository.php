<?php

namespace App\Repository;

use App\Entity\RendezVous;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RendezVous>
 *
 * @method RendezVous|null find($id, $lockMode = null, $lockVersion = null)
 * @method RendezVous|null findOneBy(array $criteria, array $orderBy = null)
 * @method RendezVous[]    findAll()
 * @method RendezVous[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RendezVousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RendezVous::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(RendezVous $entity, bool $flush = false): void
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
    public function remove(RendezVous $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param \DateTimeImmutable $dateTime
     * @param int $periode
     * @return RendezVous[]
     */
    public function findDayPeriodRenduVous(\DateTimeImmutable $dateTime, int $periode) {
        $day = $dateTime->format("d-m-Y");
        $start = \DateTimeImmutable::createFromFormat("d-m-Y H:i", $day." 00:00");
        $end = \DateTimeImmutable::createFromFormat("d-m-Y H:i", $day." 23:55");
        return $this->createQueryBuilder("r")
            ->andWhere("r.dateRDV BETWEEN :st AND :en")
            ->andWhere("r.periode = :p")
            ->orderBy("r.dateRDV", "ASC")
            ->setParameter("st", $start)
            ->setParameter("en", $start)
            ->setParameter("p", $periode)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return RendezVous[] Returns an array of RendezVous objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RendezVous
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
