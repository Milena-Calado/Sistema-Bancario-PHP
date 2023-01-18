<?php

namespace App\DataFixtures;

use App\Entity\Agencia;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    )
    {}

    public function load(ObjectManager $manager): void
    {
        $user1 = new User(); 
        $user1->setEmail('mcsa@cin.ufpe.br');
        $user1->setPassword(
            $this->hasher->hashPassword($user1, '123456')
        );
        $manager->persist($user1);

        $user2 = new User(); 
        $user2->setEmail('milena@cin.ufpe.br');
        $user2->setPassword(
            $this->hasher->hashPassword($user2, '123456')
        );
        $manager->persist($user2);
        
        $manager->flush();
    }
}
