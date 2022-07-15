<?php

namespace App\Entity;

use App\Repository\DepensesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: DepensesRepository::class)]
class Depenses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'float')]
    #[Assert\Type("float")]
    private $prix;

    #[ORM\Column(type: 'integer',options: ["default" => 0])]
    #[Assert\Type("integer")]
    #[Assert\Range(min: 0)]
    private $nbrMois;

    #[ORM\Column(type: 'integer',options: ["default" => 0])]
    #[Assert\Type("integer")]
    #[Assert\Range(min: 0,max: 31)]
    private $nbrJours;

    #[ORM\Column(type: 'date')]
    private $date_creation;

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

    public function getNbrMois(): ?int
    {
        return $this->nbrMois;
    }

    public function setNbrMois(int $nbrMois): self
    {
        $this->nbrMois = $nbrMois;

        return $this;
    }

    public function getNbrJours(): ?int
    {
        return $this->nbrJours;
    }

    public function setNbrJours(int $nbrJours): self
    {
        $this->nbrJours = $nbrJours;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }
}
