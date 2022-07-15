<?php

namespace App\Repository;

use App\Entity\Depenses;
use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Depenses>
 *
 * @method Depenses|null find($id, $lockMode = null, $lockVersion = null)
 * @method Depenses|null findOneBy(array $criteria, array $orderBy = null)
 * @method Depenses[]    findAll()
 * @method Depenses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepensesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Depenses::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Depenses $entity, bool $flush = false): void
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
    public function remove(Depenses $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Patient[] Returns an array of Patient objects
     */
    public function findByName($value=''): array
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.id', 'ASC')
            ->andWhere("d.nom LIKE :search")
            ->setParameter('search', $value.'%')
            ->getQuery()
            ->getResult()
            ;
    }


    /**
     * @return Depenses[] Returns an array of Depenses objects
     */
    public function getPriceByDay(): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Depenses
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
