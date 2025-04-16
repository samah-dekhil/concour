<?php

namespace App\Entity;

use App\Repository\PhaseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhaseRepository::class)]
class Phase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $libelle = null;



    #[ORM\Column]
    private \DateTime $dateDebut;

    #[ORM\Column]
    private \DateTime $dateFin;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $dateCreation;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $dateModification; 

    #[ORM\ManyToOne(targetEntity: Concours::class, inversedBy: 'phases')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Concours $concours = null;

    #[ORM\Column(type: 'boolean')]
    private $isEnabled = false;


    #[ORM\Column(type: 'json', nullable:true)]
    private array $grades = [];



    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->dateModification = new \DateTime();
      
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

  

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

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

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(\DateTimeInterface $dateModification): static
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    public function isIsEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): static
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    public function getConcours(): ?Concours
    {
        return $this->concours;
    }

    public function setConcours(?Concours $concours): static
    {
        $this->concours = $concours;

        return $this;
    }

    public function getGrades(): array
    {
        return $this->grades;
    }

    public function setGrades(array $grades): static
    {
        $this->grades = $grades;

        return $this;
    }

    

  

}
