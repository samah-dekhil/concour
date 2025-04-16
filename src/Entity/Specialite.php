<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: SpecialiteRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Specialite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $libelle = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $dateCreation;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $dateModification;

    // #[ORM\ManyToMany(targetEntity: Gouvernorat::class, mappedBy: 'specialites')]
    // #[ORM\JoinTable(name: 'gouvernorats_specialites')]
    // #[ORM\JoinColumn(name:"gouvernorat_id", referencedColumnName:"codeGouv")]
    // private Collection $gouvts;

    #[ORM\ManyToMany(targetEntity: Gouvernorat::class, inversedBy: 'specialites')]
    #[ORM\JoinTable(name: 'gouvernorats_specialites')]
    #[Assert\Count(min: 1, max : 24)]
    private Collection $gouvernorats;


    #[ORM\ManyToOne(targetEntity: Grade::class, inversedBy: 'specialites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Grade $grade = null;

 
    /**
     * @var Inscription []|Collection
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'specialite', orphanRemoval: true, cascade: ['persist'])]
    private Collection $inscriptions;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->dateModification = new \DateTime();
        $this->gouvernorats = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
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
     * @return Collection<int, Gouvernorat>
     */
    public function getGouvernorats(): Collection
    {
        return $this->gouvernorats;
    }

    public function addGouvernorat(Gouvernorat $gouvernorat): static
    {
        if (!$this->gouvernorats->contains($gouvernorat)) {
            $this->gouvernorats->add($gouvernorat);
        }

        return $this;
    }

    public function removeGouvernorat(Gouvernorat $gouvernorat): static
    {
        $this->gouvernorats->removeElement($gouvernorat);

        return $this;
    }

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setSpecialite($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getSpecialite() === $this) {
                $inscription->setSpecialite(null);
            }
        }

        return $this;
    }



   
}
