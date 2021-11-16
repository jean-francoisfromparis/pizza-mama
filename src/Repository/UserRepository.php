<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements
    PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(
        PasswordAuthenticatedUserInterface $user,
        string $newHashedPassword
    ): void {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    \get_class($user)
                )
            );
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function countAllUsers()
    {
        $queryBuilder = $this ->createQueryBuilder('a');
        $queryBuilder->select('COUNT(a.id) as value');
        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findTenLastUsers()
    {
        return $this->createQueryBuilder('u')
            ->setMaxResults(10)
            ->andWhere('u.roles LIKE :val')
            ->setParameter('val', '%ROLE_USER%')
            ->orderBy('u.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return void
     */
    public function countUsersByDate()
    {
            $queryBuilder = $this->createQueryBuilder('u')
            ->select('SUBSTRING(u.createdAt, 1, 10) as userByDate, count(u) as count')
            ->groupBy('userByDate')
            ->orderBy('userByDate', 'ASC');
            return  $queryBuilder ->getQuery() ->getArrayResult();

        ;
    }
}
