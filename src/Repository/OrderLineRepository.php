<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\OrderLine;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method OrderLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderLine[]    findAll()
 * @method OrderLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderLine::class);
    }

    public function findAllById($Order)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT o
            FROM App\Entity\OrderLine o
            WHERE o.orderLine = :id'
        )->setParameter('id', $Order->getId());

        return $query->getArrayResult();
    }

    public function findLastInserted()
    {
        return $this->createQueryBuilder('o')
        // ->andWhere('o.payedAt = :val')
        // ->setParameter('val', $value)
        ->orderBy('o.id', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return OrderLine[] Returns an array of OrderLine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderLine
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
