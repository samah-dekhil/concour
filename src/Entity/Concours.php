<?php

namespace App\Entity;

use App\Repository\ConcoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ConcoursRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Concours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: UuidType::NAME,unique:true)]
    private Uuid $token;

    #[ORM\Column(length: 200)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $annee = null;
    #[ORM\Column]
    // #[Assert\Date]
    private \DateTime $dateDebutInscription;

    /**
     * @var Grade[]|Collection
     */
    #[ORM\OneToMany(targetEntity: Grade::class, mappedBy: 'concours', orphanRemoval: true, cascade: ['persist'])]
  
    private Collection $grades;
 

    #[ORM\Column]
    // #[Assert\Date]
    private \DateTime $dateFinInscription;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $dateCreation;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $dateModification; 


    /** 
     * @var Phase[]|Collection
    */
    #[ORM\OneToMany(targetEntity: Phase::class, mappedBy: 'concours', orphanRemoval: true, cascade: ['persist'])]
    private Collection $phases;
    
    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->dateModification = new \DateTime();
        $this->annee =  date("Y");
        $this->grades = new ArrayCollection();
        $this->token= Uuid::v4();
        $this->phases = new ArrayCollection();
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

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getDateDebutInscription(): ?\DateTimeInterface
    {
        return $this->dateDebutInscription;
    }

    public function setDateDebutInscription(\DateTimeInterface $dateDebutInscription): static
    {
        $this->dateDebutInscription = $dateDebutInscription;

        return $this;
    }

    public function getDateFinInscription(): ?\DateTimeInterface
    {
        return $this->dateFinInscription;
    }

    public function setDateFinInscription(\DateTimeInterface $dateFinInscription): static
    {
        $this->dateFinInscription = $dateFinInscription;

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

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setDateModificationValue()
    {
            $this->setDateModification(new \DateTime());
    }

    /**
     * @return Collection<int, Grade>
     */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function addGrade(Grade $grade): static
    {
        if (!$this->grades->contains($grade)) {
            $this->grades->add($grade);
            $grade->setConcours($this);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): static
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getConcours() === $this) {
                $grade->setConcours(null);
            }
        }

        return $this;
    }

    public function getToken(): ?Uuid
    {
        return $this->token;
    }

    public function setToken(Uuid $token): static
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection<int, Phase>
     */
    public function getPhases(): Collection
    {
        return $this->phases;
    }

    public function addPhase(Phase $phase): static
    {
        if (!$this->phases->contains($phase)) {
            $this->phases->add($phase);
            $phase->setConcours($this);
        }

        return $this;
    }

    public function removePhase(Phase $phase): static
    {
        if ($this->phases->removeElement($phase)) {
            // set the owning side to null (unless already changed)
            if ($phase->getConcours() === $this) {
                $phase->setConcours(null);
            }
        }

        return $this;
    }
}