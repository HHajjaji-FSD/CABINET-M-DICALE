<?php

namespace App\Service;

use App\Entity\Setting;
use Doctrine\ORM\EntityManagerInterface;

class MyOps
{
    const JOURS = [
        1 => "Lundi",
        2 => "Mardi",
        3 => "Mercredi",
        4 => "Jeudi",
        5 => "Vendredi",
        6 => "Samedi",
        7 => "Dimanche"
    ];

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getDays(): array
    {
        return self::JOURS;
    }

    /**
     * @return Setting
     */
    public function getSetting() {
        /** @var Setting $setting */
        $setting = $this->entityManager->getRepository(Setting::class)->findOneBy([]);

        return $setting;
    }
}