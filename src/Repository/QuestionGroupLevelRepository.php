<?php

namespace App\Repository;

use App\Entity\QuestionGroupLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuestionGroupLevel>
 *
 * @method QuestionGroupLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionGroupLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionGroupLevel[]    findAll()
 * @method QuestionGroupLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionGroupLevelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionGroupLevel::class);
    }

//    /**
//     * @return QuestionGroupLevel[] Returns an array of QuestionGroupLevel objects
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

//    public function findOneBySomeField($value): ?QuestionGroupLevel
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
