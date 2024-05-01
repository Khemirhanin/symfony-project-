<?php

namespace App\Entity;

use App\Repository\RecipesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipesRepository::class)]
class Recipes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 100)]
    private ?string $Type = null;

    #[ORM\Column]
    private ?int $Time = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $NbServings = null;

    #[ORM\Column(length: 60)]
    private ?string $Difficulty = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $Ingredients = null;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $Confirm = null;



    #[ORM\Column(nullable: true)]
    private ?float $AverageRating = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    private ?Users $IdUser = null;

    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'Recipe')]
    private Collection $reviews;

    #[ORM\Column(length: 255)]
    private ?string $Image = null;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->Time;
    }

    public function setTime(int $Time): static
    {
        $this->Time = $Time;

        return $this;
    }

    public function getNbServings(): ?int
    {
        return $this->NbServings;
    }

    public function setNbServings(int $NbServings): static
    {
        $this->NbServings = $NbServings;

        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->Difficulty;
    }

    public function setDifficulty(string $Difficulty): static
    {
        $this->Difficulty = $Difficulty;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->Ingredients;
    }

    public function setIngredients(?string $Ingredients): static
    {
        $this->Ingredients = $Ingredients;

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

    public function getConfirm(): ?int
    {
        return $this->Confirm;
    }

    public function setConfirm(int $Confirm): static
    {
        $this->Confirm = $Confirm;

        return $this;
    }



    public function getAverageRating(): ?float
    {
        return $this->AverageRating;
    }

    public function setAverageRating(?float $AverageRating): static
    {
        $this->AverageRating = $AverageRating;

        return $this;
    }

    public function getIdUser(): ?Users
    {
        return $this->IdUser;
    }

    public function setIdUser(?Users $IdUser): static
    {
        $this->IdUser = $IdUser;

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setRecipe($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getRecipe() === $this) {
                $review->setRecipe(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): static
    {
        $this->Image = $Image;

        return $this;
    }
}
