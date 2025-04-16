<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
#[ORM\Entity(repositoryClass: GradeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: UuidType::NAME,unique:true)]
    private Uuid $token;

    #[ORM\Column(length: 60)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $nbre_postes = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $dateCreation;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $dateModification;

    #[ORM\ManyToOne(targetEntity: Concours::class, inversedBy: 'grades')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Concours $concours = null;

    /**
     * @var Specialite[]|Collection
     */
    #[ORM\OneToMany(targetEntity: Specialite::class, mappedBy: 'grade', orphanRemoval: true, cascade: ['persist'])]
  
    private Collection $specialites;


    //  /**
    //  * @var Inscription []|Collection
    //  */
    // #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'grade', orphanRemoval: true, cascade: ['persist'])]
    // private Collection $inscrits;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->dateModification = new \DateTime();
        $this->specialites = new ArrayCollection();
        // $this->inscrits = new ArrayCollection();

        $this->token= Uuid::v4();

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

    public function getNbrePostes(): ?int
    {
        return $this->nbre_postes;
    }

    public function setNbrePostes(int $nbre_postes): static
    {
        $this->nbre_postes = $nbre_postes;

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
  

    public function getConcours(): ?Concours
    {
        return $this->concours;
    }

    public function setConcours(?Concours $concours): static
    {
        $this->concours = $concours;

        return $this;
    }

    /**
     * @return Collection<int, Specialite>
     */
    public function getSpecialites(): Collection
    {
        return $this->specialites;
    }

    public function addSpecialite(Specialite $specialite): static
    {
        if (!$this->specialites->contains($specialite)) {
            $this->specialites->add($specialite);
            $specialite->setGrade($this);
        }

        return $this;
    }

    public function removeSpecialite(Specialite $specialite): static
    {
        if ($this->specialites->removeElement($specialite)) {
            // set the owning side to null (unless already changed)
            if ($specialite->getGrade() === $this) {
                $specialite->setGrade(null);
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

    
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setDateModificationValue()
    {
            $this->setDateModification(new \DateTime());
    }

}
