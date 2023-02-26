<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $Day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $LunchStart = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $LunchEnd = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $DinnerStart = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $DinnerEnd = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->Day;
    }

    public function setDay(string $Day): self
    {
        $this->Day = $Day;

        return $this;
    }

    public function getLunchStart(): ?\DateTimeInterface
    {
        return $this->LunchStart;
    }

    public function setLunchStart(\DateTimeInterface $LunchStart): self
    {
        $this->LunchStart = $LunchStart;

        return $this;
    }

    public function getLunchEnd(): ?\DateTimeInterface
    {
        return $this->LunchEnd;
    }

    public function setLunchEnd(\DateTimeInterface $LunchEnd): self
    {
        $this->LunchEnd = $LunchEnd;

        return $this;
    }

    public function getDinnerStart(): ?\DateTimeInterface
    {
        return $this->DinnerStart;
    }

    public function setDinnerStart(\DateTimeInterface $DinnerStart): self
    {
        $this->DinnerStart = $DinnerStart;

        return $this;
    }

    public function getDinnerEnd(): ?\DateTimeInterface
    {
        return $this->DinnerEnd;
    }

    public function setDinnerEnd(\DateTimeInterface $DinnerEnd): self
    {
        $this->DinnerEnd = $DinnerEnd;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
