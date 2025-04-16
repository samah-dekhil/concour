<?php

namespace App\Entity;

use App\Repository\GouvernoratRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GouvernoratRepository::class)]
class Gouvernorat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $libelleGouv = null;

   

    #[ORM\ManyToMany(targetEntity: Specialite::class, mappedBy: 'gouvernorats')]
    #[ORM\JoinTable(name: 'gouvernorats_specialites')]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $specialites;


     /**
     * @var Inscription []|Collection
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'codeGouv', orphanRemoval: true, cascade: ['persist'])]
    private Collection $inscrits;


    public function __construct()
    {
        
         $this->specialites = new ArrayCollection();
         $this->inscrits = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleGouv(): ?string
    {
        return $this->libelleGouv;
    }

    public function setLibelleGouv(string $libelleGouv): static
    {
        $this->libelleGouv = $libelleGouv;

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
            $specialite->addGouvernorat($this);
        }

        return $this;
    }

    public function removeSpecialite(Specialite $specialite): static
    {
        if ($this->specialites->removeElement($specialite)) {
            $specialite->removeGouvernorat($this);
        }

        return $this;
    }
    public function __toString() {
        return $this->libelleGouv;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscrits(): Collection
    {
        return $this->inscrits;
    }

    public function addInscrit(Inscription $inscrit): static
    {
        if (!$this->inscrits->contains($inscrit)) {
            $this->inscrits->add($inscrit);
            $inscrit->setCodeGouv($this);
        }

        return $this;
    }

    public function removeInscrit(Inscription $inscrit): static
    {
        if ($this->inscrits->removeElement($inscrit)) {
            // set the owning side to null (unless already changed)
            if ($inscrit->getCodeGouv() === $this) {
                $inscrit->setCodeGouv(null);
            }
        }

        return $this;
    }
}
