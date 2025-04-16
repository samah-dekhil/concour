<?php

namespace App\Entity;

use App\Repository\InscriptionConvocationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
#[ORM\Entity(repositoryClass: InscriptionConvocationRepository::class)]
class InscriptionConvocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 4)]
    private ?int $rangGrade = null;

    #[ORM\Column(length:5)]
    private ?int $idDossier = null;

    #[ORM\Column(length: 8)]
    private ?string $cin = null;

    #[ORM\Column(length: 10)]
    private ?string  $dateNaissance = null;


    #[ORM\Column(length: 31)]
    private ?string $nomPrenom = null;

    #[ORM\Column(length: 8, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 6)]
    private ?string $scoreTotal = null;

    #[ORM\Column(length: 3)]
    private ?int $rang = null;

    #[ORM\Column(length: 30)]
    private ?string $gouvConcours = null;

    #[ORM\Column(length: 30)]
    private ?string $specialite = null;

    #[ORM\Column(length: 30)]
    private ?string $idSpecialite = null;
    
    #[ORM\Column(length: 2)]
    private ?string $idGrade = null;
    


    public function getId(): ?int
    {
        return $this->id;
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

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(string $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getNomPrenom(): ?string
    {
        return $this->nomPrenom;
    }

    public function setNomPrenom(string $nomPrenom): static
    {
        $this->nomPrenom = $nomPrenom;

        return $this;
    }

    public function getScoreTotal(): ?string
    {
        return $this->scoreTotal;
    }

    public function setScoreTotal(string $scoreTotal): static
    {
        $this->scoreTotal = $scoreTotal;

        return $this;
    }

    public function getRang(): ?int
    {
        return $this->rang;
    }

    public function setRang(int $rang): static
    {
        $this->rang = $rang;

        return $this;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getRangGrade(): ?int
    {
        return $this->rangGrade;
    }

    public function setRangGrade(int $rangGrade): static
    {
        $this->rangGrade = $rangGrade;

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
