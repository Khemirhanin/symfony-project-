<?php

namespace App\Entity;

use App\Repository\ReviewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class Reviews
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $Rate = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $User = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipes $Recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->Rate;
    }

    public function setRate(?int $Rate): static
    {
        $this->Rate = $Rate;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->User;
    }

    public function setUser(?Users $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getRecipe(): ?Recipes
    {
        return $this->Recipe;
    }

    public function setRecipe(?Recipes $Recipe): static
    {
        $this->Recipe = $Recipe;

        return $this;
    }
}
