<?php

namespace App\Entity;

use App\Repository\AttendRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendRepository::class)]
class Attend
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $sequence;

    #[ORM\Column(type: 'boolean')]
    private $isPassed;

    #[ORM\OneToOne(mappedBy: 'attend', targetEntity: Patient::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $patient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(int $sequence): self
    {
        $this->sequence = $sequence;

        return $this;
    }

    public function getIsPassed(): ?int
    {
        return $this->isPassed;
    }

    public function setIsPassed(int $isPassed): self
    {
        $this->isPassed = $isPassed;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        // unset the owning side of the relation if necessary
        if ($patient === null && $this->patient !== null) {
            $this->patient->setAttend(null);
        }

        // set the owning side of the relation if necessary
        if ($patient !== null && $patient->getAttend() !== $this) {
            $patient->setAttend($this);
        }

        $this->patient = $patient;

        return $this;
    }
}
