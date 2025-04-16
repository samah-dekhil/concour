<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueRepository::class)]
class Historique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $grade = null;

    #[ORM\Column(length: 8)]
    private ?string $cin = null;

    #[ORM\Column]
    private ?int $idDossier = null;

    // #[ORM\Column(length: 255)]
    // private ?string $libelle = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $dateCreation;

    #[ORM\Column(length: 10)]
    private ?string $phase = null;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
       

    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

  

    public function getIdDossier(): ?int
    {
        return $this->idDossier;
    }

    public function setIdDossier(int $idDossier): static
    {
        $this->idDossier = $idDossier;

        return $this;
    }

   

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getPhase(): ?string
    {
        return $this->phase;
    }

    public function setPhase(string $phase): static
    {
        $this->phase = $phase;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): static
    {
        $this->cin = $cin;

        return $this;
    }
}
