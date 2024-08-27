<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findRandom(): User
    {
        $result = $this->createQueryBuilder('u')
            ->select('u.id')
            ->getQuery()
            ->getResult();

        $allIds = array_column($result, 'id');

        $randomId = $allIds[array_rand($allIds)];

        return $this->find($randomId);
    }

    public function findRandomAdmin(): User
    {
        $result = $this->createQueryBuilder('u')
            ->select('u.id')
            ->andWhere('u.isAdmin = :value')
            ->setParameter('value', true)
            ->getQuery()
            ->getResult();

        $allIds = array_column($result, 'id');

        $randomId = $allIds[array_rand($allIds)];

        return $this->find($randomId);
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
