<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    /**
     * l'encodeur de mot de passe
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        // the password :password
        $hashPassword =
            '$2y$13$AIX/MadGpGDP/5991rEEJO4yiTGmWawgSZMKro9/FfyRWgThoQkcW';
        for ($i = 0; $i <12 ; $i++) {
            $user = new User();
            $user
                ->setEmail("user{$i}@email.fr")
                // the password :password
                ->setPassword($hashPassword)
                ->setRoles(['ROLE_USER'])
                ->setCreatedAt(new \dateTimeImmutable(sprintf('-%d days', rand(1, 100))));
            $manager->persist($user);
        }
        for ($i = 0; $i < 2; $i++) {
            $user = new User();
            $user
                ->setEmail("admin{$i}@email.fr")
                // the password :password
                ->setPassword($hashPassword)
                ->setRoles(['ROLE_ADMIN'])
                ->setCreatedAt(new \dateTimeImmutable('2021-10-21'));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
