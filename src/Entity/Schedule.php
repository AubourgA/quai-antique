<?php

namespace App\Entity;

use App\Entity\Admin;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ScheduleRepository;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $Day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $LunchStart = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $LunchEnd = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $DinnerStart = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $DinnerEnd = null;

    #[ORM\ManyToOne(targetEntity: Admin::class, cascade:['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Admin $Admin = null;

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

    public function getAdmin(): ?Admin
    {
        return $this->Admin;
    }

    public function setAdmin(?Admin $Admin): self
    {
        $this->Admin = $Admin;

        return $this;
    }
}
