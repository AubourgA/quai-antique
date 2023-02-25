<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $Price = null;

    #[ORM\Column(length: 255)]
    private ?string $url_image = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\ManyToMany(targetEntity: Dessert::class, inversedBy: 'menus')]
    private Collection $dessert;

    #[ORM\ManyToMany(targetEntity: Meals::class, inversedBy: 'menus')]
    private Collection $meals;

    #[ORM\ManyToMany(targetEntity: Entree::class, inversedBy: 'menus')]
    private Collection $entree;

    public function __construct()
    {
        $this->dessert = new ArrayCollection();
        $this->meals = new ArrayCollection();
        $this->entree = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable( 'now', new \DateTimeZone('+0100'));
        $this->isActive = 1;
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->Price;
    }

    public function setPrice(string $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getUrlImage(): ?string
    {
        return $this->url_image;
    }

    public function setUrlImage(string $url_image): self
    {
        $this->url_image = $url_image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, Dessert>
     */
    public function getDessert(): Collection
    {
        return $this->dessert;
    }

    public function addDessert(Dessert $dessert): self
    {
        if (!$this->dessert->contains($dessert)) {
            $this->dessert->add($dessert);
        }

        return $this;
    }

    public function removeDessert(Dessert $dessert): self
    {
        $this->dessert->removeElement($dessert);

        return $this;
    }

    /**
     * @return Collection<int, Meals>
     */
    public function getMeals(): Collection
    {
        return $this->meals;
    }

    public function addMeal(Meals $meal): self
    {
        if (!$this->meals->contains($meal)) {
            $this->meals->add($meal);
        }

        return $this;
    }

    public function removeMeal(Meals $meal): self
    {
        $this->meals->removeElement($meal);

        return $this;
    }

    /**
     * @return Collection<int, Entree>
     */
    public function getEntree(): Collection
    {
        return $this->entree;
    }

    public function addEntree(Entree $entree): self
    {
        if (!$this->entree->contains($entree)) {
            $this->entree->add($entree);
        }

        return $this;
    }

    public function removeEntree(Entree $entree): self
    {
        $this->entree->removeElement($entree);

        return $this;
    }
}
