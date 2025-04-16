<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
// use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
#[ORM\Table(name: 'inscription')]
#[ORM\UniqueConstraint(name: 'my_unique_index', columns: ['grade','cin'])]

// #[UniqueEntity(fields: ['cin'], message: 'لا يمكن التسجيل أكثر من مرة واحدة بهذه المناظرة.')]
// #[UniqueEntity(fields: ['cin','specialite'], message: 'لا يمكن التسجيل أكثر من مرة واحدة بهذه المناظرة.')]

#[UniqueEntity(
    fields: ['grade', 'cin'],
    errorPath: 'cin',
    message: 'لا يمكن التسجيل أكثر من مرة واحدة بهذه المناظرة.',
)]
// #[UniqueEntity(fields:["cin", "specialite"], message:'لا يمكن التسجيل أكثر من مرة بالمناظرة') ]

class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'id_dossier')]
    private ?int $id = null;

    #[ORM\Column(type: UuidType::NAME,unique:true)]
    private Uuid $token;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTime $dateInscription = null;

    #[ORM\ManyToOne(targetEntity: Gouvernorat::class, inversedBy: 'inscrits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gouvernorat $codeGouv = null;

    // #[ORM\Column(length: 8)]
    #[ORM\Column(length: 8)]
  //  #[Assert\Cin]
    private ?string $cin = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTime  $dateCin = null;

    #[ORM\Column(length: 30)]
    private ?string $prenom = null;

    #[ORM\Column(length: 30)]
    private ?string $nom = null;

    #[ORM\Column(length: 30)]
    private ?string $prenomPere = null;

    #[ORM\Column(length: 30)]
    private ?string $prenomMere = null;

    #[ORM\Column(length: 30)]
    private ?string $nomJeunefille = null;

    #[ORM\Column(type: 'date')]
    private ? \DateTime $dateNaissance = null;
   
    #[ORM\Column(length: 2)]
    private ?string $villeNaissance = null;

    #[ORM\Column(length: 4)]
    private ?string $sexe = null;

    #[ORM\Column(length: 5)]
    private ?string $etatCivil = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $nomPrenomConjoint = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $emploiConjoint = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $nbEnfants = null;

    #[ORM\Column(length: 300)]
    private ?string $adresse = null;

    #[ORM\Column(length: 30)]
    private ?string $regionAdresse = null;

    #[ORM\Column(length: 2)]
    private ?string $codeGouvAdresse = null;

    #[ORM\Column(length: 4)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 8, nullable: true)]
    private ?string $telephoneFixe = null;

    #[ORM\Column(length: 8)]
    private ?string $telephonePortable = null;

    #[ORM\Column(length: 30)]
    private ?string $mail = null;

    #[ORM\Column(length: 10)]
    private ?string $niveau = null;

    #[ORM\Column(length: 400)]
    private ?string $niveauAffiche = null;

    #[ORM\Column(length: 100)]
    private ?string $nomDiplome = null;

    #[ORM\Column(length: 200,nullable: true)]
    private ?string $specialiteDiplome = null;

    #[ORM\Column(length: 7)]
    private ?string $typeEtablissement = null;

    #[ORM\Column(length: 4)]
    private ?string $anneeDiplome = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $anneeEquivalence = null;

    #[ORM\Column(length: 200)]
    private ?string $nomEtablissement = null;

    #[ORM\Column(length: 6)]
    private ?string $moyenne1 = null;

    #[ORM\Column(length: 6)]
    private ?string $moyenne2 = null;

    #[ORM\Column(length: 6, nullable: true)]
    private ?string $moyenne3 = null;

    #[ORM\Column(length: 6, nullable: true)]
    private ?string $moyenne4 = null;

    #[ORM\Column(length: 6, nullable: true)]
    private ?string $moyenne5 = null;

    #[ORM\Column(length: 6)]
    private ?string $moyenneGenerale = null;

    #[ORM\Column(length: 6)]
    private ?string $scoreTanfil = null;

    #[ORM\Column(length: 6)]
    private ?string $totalScore = null;


    #[ORM\Column(length: 9)]
    private ?string $diplomeTanfil = null;

    #[ORM\Column(type: 'boolean')]
    private $confirmGuide ;

    #[ORM\Column(type: 'boolean')]
    private $confirmDecision ;

    #[ORM\Column(type: 'boolean')]
    private  $confirmProgramme ;

    #[ORM\Column(type: 'boolean')]
    private  $confirmFiche ;

    #[ORM\ManyToOne(targetEntity: Specialite::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Specialite $specialite = null;

    // #[ORM\ManyToOne(targetEntity: Grade::class, inversedBy: 'inscrits')]
    // #[ORM\JoinColumn(nullable: false)]
    // private ?Grade $grade = null;
    
     
    #[ORM\Column(length: 2 ,type: 'integer')]
    private ?int $grade = null;


   
    public function __construct()
    {
        $this->dateInscription = new \DateTime();
        $this->token= Uuid::v4();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

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

    public function getDateCin(): ?\DateTimeInterface
    {
        return $this->dateCin;
    }
/*
    public function setDateCin(\DateTimeInterface $dateCin): static
    {
        $this->dateCin = $dateCin;

        return $this;
    }
*/

    public function setDateCin(?\DateTimeInterface $dateCin): self
    {
        $this->dateCin = $dateCin;

        return $this;
    }
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenomPere(): ?string
    {
        return $this->prenomPere;
    }

    public function setPrenomPere(string $prenomPere): static
    {
        $this->prenomPere = $prenomPere;

        return $this;
    }

    public function getPrenomMere(): ?string
    {
        return $this->prenomMere;
    }

    public function setPrenomMere(string $prenomMere): static
    {
        $this->prenomMere = $prenomMere;

        return $this;
    }

    public function getNomJeunefille(): ?string
    {
        return $this->nomJeunefille;
    }

    public function setNomJeunefille(string $nomJeunefille): static
    {
        $this->nomJeunefille = $nomJeunefille;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getVilleNaissance(): ?string
    {
        return $this->villeNaissance;
    }

    public function setVilleNaissance(string $villeNaissance): static
    {
        $this->villeNaissance = $villeNaissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getEtatCivil(): ?string
    {
        return $this->etatCivil;
    }

    public function setEtatCivil(string $etatCivil): static
    {
        $this->etatCivil = $etatCivil;

        return $this;
    }

    public function getNomPrenomConjoint(): ?string
    {
        return $this->nomPrenomConjoint;
    }

    public function setNomPrenomConjoint(?string $nomPrenomConjoint): static
    {
        $this->nomPrenomConjoint = $nomPrenomConjoint;

        return $this;
    }

    public function getEmploiConjoint(): ?string
    {
        return $this->emploiConjoint;
    }

    public function setEmploiConjoint(?string $emploiConjoint): static
    {
        $this->emploiConjoint = $emploiConjoint;

        return $this;
    }

    public function getNbEnfants(): ?string
    {
        return $this->nbEnfants;
    }

    public function setNbEnfants(?string $nbEnfants): static
    {
        $this->nbEnfants = $nbEnfants;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodeGouvAdresse(): ?string
    {
        return $this->codeGouvAdresse;
    }

    public function setCodeGouvAdresse(string $codeGouvAdresse): static
    {
        $this->codeGouvAdresse = $codeGouvAdresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getTelephoneFixe(): ?string
    {
        return $this->telephoneFixe;
    }

    public function setTelephoneFixe(?string $telephoneFixe): static
    {
        $this->telephoneFixe = $telephoneFixe;

        return $this;
    }

    public function getTelephonePortable(): ?string
    {
        return $this->telephonePortable;
    }

    public function setTelephonePortable(string $telephonePortable): static
    {
        $this->telephonePortable = $telephonePortable;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getNiveauAffiche(): ?string
    {
        return $this->niveauAffiche;
    }

    public function setNiveauAffiche(string $niveauAffiche): static
    {
        $this->niveauAffiche = $niveauAffiche;

        return $this;
    }

    public function getNomDiplome(): ?string
    {
        return $this->nomDiplome;
    }

    public function setNomDiplome(string $nomDiplome): static
    {
        $this->nomDiplome = $nomDiplome;

        return $this;
    }

    public function getSpecialiteDiplome(): ?string
    {
        return $this->specialiteDiplome;
    }

    public function setSpecialiteDiplome(string $specialiteDiplome): static
    {
        $this->specialiteDiplome = $specialiteDiplome;

        return $this;
    }

    public function getTypeEtablissement(): ?string
    {
        return $this->typeEtablissement;
    }

    public function setTypeEtablissement(string $typeEtablissement): static
    {
        $this->typeEtablissement = $typeEtablissement;

        return $this;
    }

    public function getAnneDiplome(): ?string
    {
        return $this->anneeDiplome;
    }

    public function setAnneDiplome(string $anneeDiplome): static
    {
        $this->anneeDiplome = $anneeDiplome;

        return $this;
    }

    public function getNomEtablissement(): ?string
    {
        return $this->nomEtablissement;
    }

    public function setNomEtablissement(string $nomEtablissement): static
    {
        $this->nomEtablissement = $nomEtablissement;

        return $this;
    }

    public function getMoyenne1(): ?string
    {
        return $this->moyenne1;
    }

    public function setMoyenne1(string $moyenne1): static
    {
        $this->moyenne1 = $moyenne1;

        return $this;
    }

    public function getMoyenne2(): ?string
    {
        return $this->moyenne2;
    }

    public function setMoyenne2(string $moyenne2): static
    {
        $this->moyenne2 = $moyenne2;

        return $this;
    }

    public function getMoyenne3(): ?string
    {
        return $this->moyenne3;
    }

    public function setMoyenne3(?string $moyenne3): static
    {
        $this->moyenne3 = $moyenne3;

        return $this;
    }

    public function getMoyenne4(): ?string
    {
        return $this->moyenne4;
    }

    public function setMoyenne4(?string $moyenne4): static
    {
        $this->moyenne4 = $moyenne4;

        return $this;
    }

    public function getMoyenne5(): ?string
    {
        return $this->moyenne5;
    }

    public function setMoyenne5(?string $moyenne5): static
    {
        $this->moyenne5 = $moyenne5;

        return $this;
    }

    public function getMoyenneGenerale(): ?string
    {
        return $this->moyenneGenerale;
    }

    public function setMoyenneGenerale(string $moyenneGenerale): static
    {
        $this->moyenneGenerale = $moyenneGenerale;

        return $this;
    }

    public function getScoreTanfil(): ?string
    {
        return $this->scoreTanfil;
    }

    public function setScoreTanfil(string $scoreTanfil): static
    {
        $this->scoreTanfil = $scoreTanfil;

        return $this;
    }

    public function getTotalScore(): ?string
    {
        return $this->totalScore;
    }

    public function setTotalScore(string $totalScore): static
    {
        $this->totalScore = $totalScore;

        return $this;
    }

    public function isConfirmGuide(): ?bool
    {
        return $this->confirmGuide;
    }

    public function setConfirmGuide(bool $confirmGuide): static
    {
        $this->confirmGuide = $confirmGuide;

        return $this;
    }

    public function isConfirmDecision(): ?bool
    {
        return $this->confirmDecision;
    }

    public function setConfirmDecision(bool $confirmDecision): static
    {
        $this->confirmDecision = $confirmDecision;

        return $this;
    }

    public function isConfirmProgramme(): ?bool
    {
        return $this->confirmProgramme;
    }

    public function setConfirmProgramme(bool $confirmProgramme): static
    {
        $this->confirmProgramme = $confirmProgramme;

        return $this;
    }

    public function isConfirmFiche(): ?bool
    {
        return $this->confirmFiche;
    }

    public function setConfirmFiche(bool $confirmFiche): static
    {
        $this->confirmFiche = $confirmFiche;

        return $this;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialite $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getCodeGouv(): ?Gouvernorat
    {
        return $this->codeGouv;
    }

    public function setCodeGouv(?Gouvernorat $codeGouv): static
    {
        $this->codeGouv = $codeGouv;

        return $this;
    }

    public function getAnneeDiplome(): ?string
    {
        return $this->anneeDiplome;
    }

    public function setAnneeDiplome(string $anneeDiplome): static
    {
        $this->anneeDiplome = $anneeDiplome;

        return $this;
    }

    public function getAnneeEquivalence(): ?string
    {
        return $this->anneeEquivalence;
    }

    public function setAnneeEquivalence(string $anneeEquivalence): static
    {
        $this->anneeEquivalence = $anneeEquivalence;

        return $this;
    }

    public function getDiplomeTanfil(): ?string
    {
        return $this->diplomeTanfil;
    }

    public function setDiplomeTanfil(string $diplomeTanfil): static
    {
        $this->diplomeTanfil = $diplomeTanfil;

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

    public function getRegionAdresse(): ?string
    {
        return $this->regionAdresse;
    }

    public function setRegionAdresse(string $regionAdresse): static
    {
        $this->regionAdresse = $regionAdresse;

        return $this;
    }

    public function getGrade(): ?int
    {
        return $this->grade;
    }

    public function setGrade(int $grade): static
    {
        $this->grade = $grade;

        return $this;
    }


   

 

}
