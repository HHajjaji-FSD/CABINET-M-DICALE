<?php

namespace App\Twig;

use App\Repository\PatientRepository;

class PatientStatistiques
{
    private $repo;

    public function __construct(PatientRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getNumberAll()
    {
        return count($this->repo->findAll());
    }

    public function getNumberRendezvous()
    {
        return count($this->repo->findByRendezVous());
    }

    public function getNumberArchive()
    {
        return count($this->repo->findByArchive());
    }

    public function getNumberAttend()
    {
        return count($this->repo->findByAttend());
    }
}