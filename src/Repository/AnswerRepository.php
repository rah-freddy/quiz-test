<?php

namespace App\Repository;

use App\Entity\Answer;
use App\Entity\QuestionGroupLevel;
use App\Entity\Questions;
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
    public function findQuestionAnswerByGroup(int $idGroup): array
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('q.text AS question_text, GROUP_CONCAT(a.text SEPARATOR \', \') AS answer_text')
            ->join('a.question', 'q')
            ->join('q.questionGroupLevel', 'g')
            ->where('g.id = :group_id')
            ->groupBy('q.id, q.text')
            ->setParameter('group_id', $idGroup);

        $query = $qb->getQuery();
        $result = $query->getResult();

        return $result;
    }

    public function findScoreByUser(int $idGroup, bool $isCorrect): array
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->select('questionGroupLevel.id as id_group', 'SUM(a.isCorrect) as score')
            ->innerJoin(Questions::class, 'question', 'WITH', 'question.id = a.question')
            ->innerJoin(QuestionGroupLevel::class, 'questionGroupLevel', 'WITH', 'questionGroupLevel.id = question.questionGroupLevel')
            ->where('questionGroupLevel.id = :groupId')
            ->andWhere('a.isCorrect = :isCorrect')
            ->setParameter('groupId', $idGroup)
            ->setParameter('isCorrect', $isCorrect);

        return $qb->getQuery()->getResult();
    }

    public function findAnswerCorrect($response): int
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('COUNT(a.isCorrect) as score');

        $orX = $qb->expr()->orX();
        foreach ($response as $index => $text) {
            $orX->add($qb->expr()->eq('a.text', ':text' . $index));
            $qb->setParameter('text' . $index, $text);
        }

        $qb->where($qb->expr()->andX(
            $qb->expr()->eq('a.isCorrect', 1),
            $orX
        ));

        $query = $qb->getQuery();
        $result = $query->getSingleScalarResult();

        return $result;
    }
}
