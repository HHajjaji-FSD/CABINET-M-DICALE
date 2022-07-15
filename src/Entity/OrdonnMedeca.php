<?php

namespace App\Entity;

use App\Repository\OrdonnMedecaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdonnMedecaRepository::class)]
class OrdonnMedeca
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $methodUitilisation;

    #[ORM\ManyToOne(targetEntity: Medecament::class, inversedBy: 'ordonnMedecas')]
    #[ORM\JoinColumn(nullable: false)]
    private $medecament;

    #[ORM\ManyToMany(targetEntity: Ordonnance::class, mappedBy: 'ordonnMedeca')]
    private $ordonnances;

    public function __construct()
    {
        $this->ordonnances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMethodUitilisation(): ?string
    {
        return $this->methodUitilisation;
    }

    public function setMethodUitilisation(?string $methodUitilisation): self
    {
        $this->methodUitilisation = $methodUitilisation;

        return $this;
    }

    public function getMedecament(): ?Medecament
    {
        return $this->medecament;
    }

    public function setMedecament(?Medecament $medecament): self
    {
        $this->medecament = $medecament;

        return $this;
    }

    /**
     * @return Collection<int, Ordonnance>
     */
    public function getOrdonnances(): Collection
    {
        return $this->ordonnances;
    }

    public function addOrdonnance(Ordonnance $ordonnance): self
    {
        if (!$this->ordonnances->contains($ordonnance)) {
            $this->ordonnances[] = $ordonnance;
            $ordonnance->addOrdonnMedeca($this);
        }

        return $this;
    }

    public function removeOrdonnance(Ordonnance $ordonnance): self
    {
        if ($this->ordonnances->removeElement($ordonnance)) {
            $ordonnance->removeOrdonnMedeca($this);
        }

        return $this;
    }

    public function __toString(){
        return $this->methodUitilisation;
    }
}
