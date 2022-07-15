<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager)
    {

        $admin = new User();
        $admin->setUsername('Admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin,'AdminPro123'));

        $secretariat = new User();
        $secretariat->setUsername('Secretariat');
        $secretariat->setRoles(['ROLE_USER']);
        $secretariat->setPassword($this->passwordHasher->hashPassword($secretariat,'AdminPro123'));

        $manager->persist($admin);
        $manager->persist($secretariat);
        $manager->flush();
    }
}
