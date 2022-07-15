<?php

namespace App\Entity;

use App\Repository\MedecamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedecamentRepository::class)]
class Medecament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'float')]
    private $prix;

    #[ORM\Column(type: 'text', nullable: true)]
    private $casUtilisation;

    #[ORM\Column(type: 'text', nullable: true)]
    private $casInterdit;

    #[ORM\OneToMany(mappedBy: 'medecament', targetEntity: OrdonnMedeca::class)]
    private $ordonnMedecas;

    public function __construct()
    {
        $this->ordonnMedecas = new ArrayCollection();
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCasUtilisation(): ?string
    {
        return $this->casUtilisation;
    }

    public function setCasUtilisation(?string $casUtilisation): self
    {
        $this->casUtilisation = $casUtilisation;

        return $this;
    }

    public function getCasInterdit(): ?string
    {
        return $this->casInterdit;
    }

    public function setCasInterdit(?string $casInterdit): self
    {
        $this->casInterdit = $casInterdit;

        return $this;
    }

    /**
     * @return Collection<int, OrdonnMedeca>
     */
    public function getOrdonnMedecas(): Collection
    {
        return $this->ordonnMedecas;
    }

    public function addOrdonnMedeca(OrdonnMedeca $ordonnMedeca): self
    {
        if (!$this->ordonnMedecas->contains($ordonnMedeca)) {
            $this->ordonnMedecas[] = $ordonnMedeca;
            $ordonnMedeca->setMedecament($this);
        }

        return $this;
    }

    public function removeOrdonnMedeca(OrdonnMedeca $ordonnMedeca): self
    {
        if ($this->ordonnMedecas->removeElement($ordonnMedeca)) {
            // set the owning side to null (unless already changed)
            if ($ordonnMedeca->getMedecament() === $this) {
                $ordonnMedeca->setMedecament(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->nom;
    }
}
