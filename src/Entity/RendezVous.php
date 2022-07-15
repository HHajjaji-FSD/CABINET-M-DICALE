<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    const TYPES_RENDUVOUS = [
        1 => "Matin Et Medi",
        2 => "1 heure / Patient",
        3 => "30min / Patient",
        4 => "15min / Patient",
        5 => "10min / Patient",
        6 => "Jour"
    ];

    const PERIODS = [
        1 => "Matin",
        2 => "PERIODS"
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $dateCreation;

    #[ORM\Column(type: 'datetime')]
    private $dateRDV;

    #[ORM\Column(type: 'boolean')]
    private $isConfermed;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'rendezVouses')]
    private $patient;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $periode;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateRDV(): ?\DateTimeInterface
    {
        return $this->dateRDV;
    }

    public function setDateRDV(\DateTimeInterface $dateRDV): self
    {
        $this->dateRDV = $dateRDV;

        return $this;
    }

    public function getIsConfermed(): ?bool
    {
        return $this->isConfermed;
    }

    public function setIsConfermed(bool $isConfermed): self
    {
        $this->isConfermed = $isConfermed;

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

    public function getPeriode(): ?int
    {
        return $this->periode;
    }

    public function setPeriode(?int $periode): self
    {
        $this->periode = $periode;

        return $this;
    }
}
