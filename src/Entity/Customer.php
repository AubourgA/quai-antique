<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $Firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $Lastname = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Allergy = null;

    #[ORM\Column(nullable: false)]
    #[Assert\NotBlank()]
    #[Assert\Regex(
        pattern :' /[0-9]/i' ,
        match:true,
        message :'Uniquement un nombre',
    )]
    private ?int $DefaultPerson = null;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Booking::class, orphanRemoval: true)]
    private Collection $bookings;

    public function __construct()
    {
        parent::__construct();
        $this->bookings = new ArrayCollection();
    }

    
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

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setCustomer($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getCustomer() === $this) {
                $booking->setCustomer(null);
            }
        }

        return $this;
    }
}
