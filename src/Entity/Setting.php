<?php

namespace App\Entity;

use App\Repository\SettingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingRepository::class)]
class Setting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', length: 1)]
    private $typeRdv;

    #[ORM\Column(type: 'float')]
    private $prixConsultation;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $numMatin;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $numMedi;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomCabinet;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $adresse;

    #[ORM\Column(type: 'string', length: 125, nullable: true)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $specialite;

    #[ORM\Column(type: 'string', length: 125, nullable: true)]
    private $logo;

    #[ORM\Column(type: 'json', nullable: true)]
    private $hours = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeRdv(): ?int
    {
        return $this->typeRdv;
    }

    public function setTypeRdv(int $typeRdv): self
    {
        $this->typeRdv = $typeRdv;

        return $this;
    }

    public function getPrixConsultation(): ?float
    {
        return $this->prixConsultation;
    }

    public function setPrixConsultation(float $prixConsultation): self
    {
        $this->prixConsultation = $prixConsultation;

        return $this;
    }

    public function getNumMatin(): ?int
    {
        return $this->numMatin;
    }

    public function setNumMatin(?int $numMatin): self
    {
        $this->numMatin = $numMatin;

        return $this;
    }

    public function getNumMedi(): ?int
    {
        return $this->numMedi;
    }

    public function setNumMedi(?int $numMedi): self
    {
        $this->numMedi = $numMedi;

        return $this;
    }

    public function getNomCabinet(): ?string
    {
        return $this->nomCabinet;
    }

    public function setNomCabinet(string $nomCabinet): self
    {
        $this->nomCabinet = $nomCabinet;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(?string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getHours(): ?array
    {
        return $this->hours;
    }

    public function setHours(?array $hours): self
    {
        $this->hours = $hours;

        return $this;
    }
}
