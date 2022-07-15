<?php

namespace App\Entity;

use App\Repository\OrdonnanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdonnanceRepository::class)]
class Ordonnance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $dateORD;

    #[ORM\Column(type: 'float')]
    private $prixFinal;

    #[ORM\OneToOne(inversedBy: 'ordonnance', targetEntity: Consultation::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $consultation;

    #[ORM\ManyToMany(targetEntity: Radio::class, inversedBy: 'ordonnances')]
    private $radio;

    #[ORM\ManyToMany(targetEntity: Medecament::class, inversedBy: 'ordonnances')]
    private $medicaments;

    public function __construct()
    {
        $this->radio = new ArrayCollection();
        $this->medicaments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateORD(): ?\DateTimeInterface
    {
        return $this->dateORD;
    }

    public function setDateORD(\DateTimeInterface $dateORD): self
    {
        $this->dateORD = $dateORD;

        return $this;
    }

    public function getPrixFinal(): ?float
    {
        return $this->prixFinal;
    }

    public function setPrixFinal(float $prixFinal): self
    {
        $this->prixFinal = $prixFinal;

        return $this;
    }

    public function getConsultation(): ?consultation
    {
        return $this->consultation;
    }

    public function setConsultation(consultation $consultation): self
    {
        $this->consultation = $consultation;

        return $this;
    }

    /**
     * @return Collection<int, Radio>
     */
    public function getRadio(): Collection
    {
        return $this->radio;
    }

    public function addRadio(Radio $radio): self
    {
        if (!$this->radio->contains($radio)) {
            $this->radio[] = $radio;
        }

        return $this;
    }

    public function removeRadio(Radio $radio): self
    {
        $this->radio->removeElement($radio);

        return $this;
    }

    /**
     * @return Collection<int, Medecament>
     */
    public function getMedicaments(): Collection
    {
        return $this->medicaments;
    }

    public function addMedicaments(Medecament $ordonnMedeca): self
    {
        if (!$this->medicaments->contains($ordonnMedeca)) {
            $this->medicaments[] = $ordonnMedeca;
        }

        return $this;
    }

    public function removeMedicaments(Medecament $ordonnMedeca): self
    {
        $this->medicaments->removeElement($ordonnMedeca);

        return $this;
    }
}
