<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GalleryRepository::class)]
class Gallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern :' /(\.|\/)(jpe?g|png)$/i' ,
        match:true,
        message :'Your file extension is not supported',
    )]
    private ?string $URLImage = null;

    #[ORM\ManyToOne]
    private ?Admin $supervisor = null;

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

    public function getURLImage(): ?string
    {
        return $this->URLImage;
    }

    public function setURLImage(string $URLImage): self
    {
        $this->URLImage = $URLImage;

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
