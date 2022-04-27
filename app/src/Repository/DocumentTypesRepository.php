<?php

namespace App\Repository;

use App\Entity\DocumentTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DocumentTypes>
 *
 * @method DocumentTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentTypes[]    findAll()
 * @method DocumentTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentTypes::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DocumentTypes $entity, bool $flush = true): void
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
    public function remove(DocumentTypes $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return DocumentTypes[] Returns an array of DocumentTypes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DocumentTypes
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
