<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerRepository;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $Lastname = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Allergy = null;

    #[ORM\Column(nullable: true)]
    private ?int $DefaultPerson = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->Firstname;
    }

    public function setFirstname(string $Firstname): self
    {
        $this->Firstname = $Firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->Lastname;
    }

    public function setLastname(string $Lastname): self
    {
        $this->Lastname = $Lastname;

        return $this;
    }

    public function getAllergy(): ?string
    {
        return $this->Allergy;
    }

    public function setAllergy(?string $Allergy): self
    {
        $this->Allergy = $Allergy;

        return $this;
    }

    public function getDefaultPerson(): ?int
    {
        return $this->DefaultPerson;
    }

    public function setDefaultPerson(?int $DefaultPerson): self
    {
        $this->DefaultPerson = $DefaultPerson;

        return $this;
    }
}
