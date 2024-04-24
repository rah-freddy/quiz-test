<?php

namespace App\Entity;

use App\Repository\QuestionGroupLevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionGroupLevelRepository::class)]
class QuestionGroupLevel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Questions::class, mappedBy: 'questionGroupLevel', cascade: ['remove'])]
    private Collection $questions;

    #[ORM\OneToMany(targetEntity: QuizUsers::class, mappedBy: 'questionGroup', cascade: ['remove'])]
    private Collection $quizUsers;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->quizUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Questions>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Questions $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuestionGroupLevel($this);
        }

        return $this;
    }

    public function removeQuestion(Questions $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuestionGroupLevel() === $this) {
                $question->setQuestionGroupLevel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, QuizUsers>
     */
    public function getQuizUsers(): Collection
    {
        return $this->quizUsers;
    }

    public function addQuizUser(QuizUsers $quizUser): static
    {
        if (!$this->quizUsers->contains($quizUser)) {
            $this->quizUsers->add($quizUser);
            $quizUser->setQuestionGroup($this);
        }

        return $this;
    }

    public function removeQuizUser(QuizUsers $quizUser): static
    {
        if ($this->quizUsers->removeElement($quizUser)) {
            // set the owning side to null (unless already changed)
            if ($quizUser->getQuestionGroup() === $this) {
                $quizUser->setQuestionGroup(null);
            }
        }

        return $this;
    }
}
