<?php

namespace App\Entity;

use App\Repository\QuizUsersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizUsersRepository::class)]
class QuizUsers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'quizUsers')]
    private ?Users $user = null;

    #[ORM\ManyToOne(inversedBy: 'quizUsers')]
    private ?QuestionGroupLevel $questionGroup = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $score = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getQuestionGroup(): ?QuestionGroupLevel
    {
        return $this->questionGroup;
    }

    public function setQuestionGroup(?QuestionGroupLevel $questionGroup): static
    {
        $this->questionGroup = $questionGroup;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }
}
