<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $dateConsultation;

    #[ORM\Column(type: 'text', nullable: true)]
    private $observationRec;
    #[ORM\Column(type: 'text', nullable: true)]
    private $observationMedcine;


    #[ORM\Column(type: 'float')]
    private $prix;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'consoltations')]
    #[ORM\JoinColumn(nullable: false)]
    private $patient;

    #[ORM\OneToOne(mappedBy: 'consultation', targetEntity: Ordonnance::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $ordonnance;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateConsultation(): ?\DateTimeInterface
    {
        return $this->dateConsultation;
    }

    public function setDateConsultation(\DateTimeInterface $dateConsultation): self
    {
        $this->dateConsultation = $dateConsultation;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getOrdonnance(): ?Ordonnance
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(Ordonnance $ordonnance): self
    {
        // set the owning side of the relation if necessary
        if ($ordonnance->getConsultation() !== $this) {
            $ordonnance->setConsultation($this);
        }

        $this->ordonnance = $ordonnance;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getObservationRec(): ?string
    {
        return $this->observationRec;
    }

    public function setObservationRec(?string $observation): self
    {
        $this->observationRec = $observation;

        return $this;
    }
    public function getObservationMedcine(): ?string
    {
        return $this->observationMedcine;
    }

    public function setObservationMedcine(?string $observation): self
    {
        $this->observationMedcine = $observation;

        return $this;
    }

}
