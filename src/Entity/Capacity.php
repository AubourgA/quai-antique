<?php

namespace App\Entity;

use App\Repository\CapacityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CapacityRepository::class)]
class Capacity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $LunchLimit = null;

    #[ORM\Column]
    private ?int $DinnerLimit = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Admin $supervisor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLunchLimit(): ?int
    {
        return $this->LunchLimit;
    }

    public function setLunchLimit(int $LunchLimit): self
    {
        $this->LunchLimit = $LunchLimit;

        return $this;
    }

    public function getDinnerLimit(): ?int
    {
        return $this->DinnerLimit;
    }

    public function setDinnerLimit(int $DinnerLimit): self
    {
        $this->DinnerLimit = $DinnerLimit;

        return $this;
    }

    public function getSupervisor(): ?Admin
    {
        return $this->supervisor;
    }

    public function setSupervisor(?Admin $supervisor): self
    {
        $this->supervisor = $supervisor;

        return $this;
    }
}
