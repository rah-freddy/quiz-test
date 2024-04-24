<?php

namespace App\Repository;

use App\Entity\Answer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Answer>
 *
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    //    /**
    //     * @return Answer[] Returns an array of Answer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Answer
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findQuestionByGroup(int $idGroup): array
    {
        $qb = $this->createQueryBuilder('a')
            ->select('DISTINCT q.text AS question_text')
            ->innerJoin('a.question', 'q')
            ->innerJoin('q.questionGroupLevel', 'g')
            ->where('g.id = :group_id')
            ->setParameter('group_id', $idGroup);

        $query = $qb->getQuery();
        $results = $query->getResult();

        return $results;
    }
    public function findAnswerByGroup(int $idGroup): array
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a.text AS answer_text')
            ->innerJoin('a.question', 'q')
            ->innerJoin('q.questionGroupLevel', 'g')
            ->where('g.id = :group_id')
            ->setParameter('group_id', $idGroup);

        $query = $qb->getQuery();
        $results = $query->getResult();

        return $results;
    }
}
