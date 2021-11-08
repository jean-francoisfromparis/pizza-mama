<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(
 *   array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

 /**
 * @return Product[] Returns an array of Product objects
 *
 */
    public function findAllAvailable()
    {
        return $this->createQueryBuilder('p')
            ->Where('p.status = 1')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
        ;
    }


    /**
     * FindOneById
     *
     * @param  mixed $value
     * @return Product
     */
    public function findOneById($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
