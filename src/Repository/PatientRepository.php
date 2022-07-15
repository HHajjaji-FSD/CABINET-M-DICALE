<?php

namespace App\Repository;

use App\Entity\Attend;
use App\Entity\Ordonnance;
use App\Entity\Patient;
use App\Entity\RendezVous;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @extends ServiceEntityRepository<Patient>
 *
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Patient $entity, bool $flush = false): void
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
    public function remove(Patient $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Patient[] Returns an array of Patient objects
     */
    public function findByFullName($value=''): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC')
            ->andWhere("p.nom LIKE :search")
            ->setParameter('search', $value.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Patient[] Returns an array of Patient objects
     */
    public function findByRendezVous($value=''): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin(RendezVous::class,'rv',Join::WITH,'p.id=rv.patient')
            ->orderBy('p.id', 'ASC')
            ->andWhere('rv.isConfermed = false')
            ->andWhere('rv.dateRDV >= :date')
            ->andWhere("p.nom LIKE :search")
            ->setParameter('search', $value.'%')
            ->setParameter('date', new \DateTime())
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Patient[] Returns an array of Patient objects
     */
    public function findByAttend($value=''): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin(Attend::class,'a',Join::WITH,'p.attend=a')
            ->orderBy('a.sequence', 'ASC')
            ->andWhere("p.attend IS NOT NULL")
            ->andWhere("p.nom LIKE :search")
            ->setParameter('search', $value.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Patient[] Returns an array of Patient objects
     */
    public function findByArchive($value=''): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->innerJoin(RendezVous::class,'r',Join::WITH,'p.id=r.patient')
            ->orderBy('p.id', 'ASC')
            ->andWhere("p.nom LIKE :search")
            ->setParameter('search', $value.'%')
            ->groupBy('p')
            ->having("MAX(r.dateRDV) < :date")
            ->setParameter('date',new DateTime())
            ->getQuery()
            ->getResult()
            ;
    }



}
