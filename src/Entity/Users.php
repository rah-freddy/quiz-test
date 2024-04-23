<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\OneToMany(targetEntity: QuizUsers::class, mappedBy: 'user', cascade: ['remove'])]
    private Collection $quizUsers;

    public function __construct()
    {
        $this->quizUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
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
            $quizUser->setUser($this);
        }

        return $this;
    }

    public function removeQuizUser(QuizUsers $quizUser): static
    {
        if ($this->quizUsers->removeElement($quizUser)) {
            // set the owning side to null (unless already changed)
            if ($quizUser->getUser() === $this) {
                $quizUser->setUser(null);
            }
        }

        return $this;
    }
}
