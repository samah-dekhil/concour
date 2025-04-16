<?php

namespace App\Entity;

use App\Repository\ScoreRegionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScoreRegionRepository::class)]
class ScoreRegion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 6)]
    private ?string $dernierScoreTotal = null;

    
    #[ORM\Column(length: 30)]
    private ?string $gouvConcours = null;

    #[ORM\Column(length: 2 ,type: 'integer')]
    private ?int $idGouv = null;
    
    #[ORM\Column(length: 30)]
    private ?string $specialite = null;

    #[ORM\Column(length: 30)]
    private ?string $idSpecialite = null;
    
    #[ORM\Column(length: 2)]
    private ?string $idGrade = null;

    #[ORM\Column(length: 30)]
    private ?string $dateNaissanceDernierCandidatAdmis = null;

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getGouvConcours(): ?string
    {
        return $this->gouvConcours;
    }

    public function setGouvConcours(string $gouvConcours): static
    {
        $this->gouvConcours = $gouvConcours;

        return $this;
    }

    public function getDernierScoreTotal(): ?string
    {
        return $this->dernierScoreTotal;
    }

    public function setDernierScoreTotal(string $dernierScoreTotal): static
    {
        $this->dernierScoreTotal = $dernierScoreTotal;

        return $this;
    }

    public function getDateNaissanceDernierCandidatAdmis(): ?string
    {
        return $this->dateNaissanceDernierCandidatAdmis;
    }

    public function setDateNaissanceDernierCandidatAdmis(string $dateNaissanceDernierCandidatAdmis): static
    {
        $this->dateNaissanceDernierCandidatAdmis = $dateNaissanceDernierCandidatAdmis;

        return $this;
    }

    public function getIdGouv(): ?int
    {
        return $this->idGouv;
    }

    public function setIdGouv(int $idGouv): static
    {
        $this->idGouv = $idGouv;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getIdSpecialite(): ?string
    {
        return $this->idSpecialite;
    }

    public function setIdSpecialite(string $idSpecialite): static
    {
        $this->idSpecialite = $idSpecialite;

        return $this;
    }

    public function getIdGrade(): ?string
    {
        return $this->idGrade;
    }

    public function setIdGrade(string $idGrade): static
    {
        $this->idGrade = $idGrade;

        return $this;
    }

}
