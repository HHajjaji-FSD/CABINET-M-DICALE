<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cin;

    #[ORM\Column(type: 'string', length: 255)]
    private $sexe;

    #[ORM\Column(type: 'date')]
    private $dateNaiss;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numMetuale;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $typeMetuale;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $responsable;

    #[ORM\Column(type: 'datetime')]
    private $dateCreation;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: RendezVous::class)]
    private $rendezVouses;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Consultation::class, orphanRemoval: true)]
    private $consoltations;

    #[ORM\OneToOne(inversedBy: 'patient', targetEntity: Attend::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $attend;

    #[ORM\Column(type: 'text', nullable: true)]
    private $maladieCroniques;


    public function __construct()
    {
        $this->rendezVouses = new ArrayCollection();
        $this->consoltations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(?string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(\DateTimeInterface $dateNaiss): self
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    public function getNumMetuale(): ?string
    {
        return $this->numMetuale;
    }

    public function setNumMetuale(string $numMetuale): self
    {
        $this->numMetuale = $numMetuale;

        return $this;
    }

    public function getTypeMetuale(): ?string
    {
        return $this->typeMetuale;
    }

    public function setTypeMetuale(?string $typeMetuale): self
    {
        $this->typeMetuale = $typeMetuale;

        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(?string $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVouses(): Collection
    {
        return $this->rendezVouses;
    }

    public function addRendezVouse(RendezVous $rendezVouse): self
    {
        if (!$this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses[] = $rendezVouse;
            $rendezVouse->setPatient($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): self
    {
        if ($this->rendezVouses->removeElement($rendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getPatient() === $this) {
                $rendezVouse->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getConsoltations(): Collection
    {
        return $this->consoltations;
    }

    public function addConsoltation(Consultation $consoltation): self
    {
        if (!$this->consoltations->contains($consoltation)) {
            $this->consoltations[] = $consoltation;
            $consoltation->setPatient($this);
        }

        return $this;
    }

    public function removeConsoltation(Consultation $consoltation): self
    {
        if ($this->consoltations->removeElement($consoltation)) {
            // set the owning side to null (unless already changed)
            if ($consoltation->getPatient() === $this) {
                $consoltation->setPatient(null);
            }
        }

        return $this;
    }

    public function getStatus()
    {
        return 'rendezvous';
    }

    public function __toString()
    {
        return $this->nom.' '.$this->prenom;
    }

    public function getAttend(): ?Attend
    {
        return $this->attend;
    }

    public function setAttend(?Attend $attend): self
    {
        $this->attend = $attend;

        return $this;
    }

    public function getMaladieCroniques(): ?string
    {
        return $this->maladieCroniques;
    }

    public function setMaladieCroniques(?string $maladieCroniques): self
    {
        $this->maladieCroniques = $maladieCroniques;

        return $this;
    }

}
