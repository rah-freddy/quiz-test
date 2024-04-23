<?php

namespace App\Repository;

use App\Entity\QuizUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuizUsers>
 *
 * @method QuizUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizUsers[]    findAll()
 * @method QuizUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizUsers::class);
    }

//    /**
//     * @return QuizUsers[] Returns an array of QuizUsers objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?QuizUsers
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
