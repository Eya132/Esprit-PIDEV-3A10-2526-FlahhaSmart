<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            [
                'nom'    => 'Admin',
                'prenom' => 'Super',
                'email'  => 'admin@flahasmart.com',
                'role'   => 'ADMINISTRATEUR',
                'pass'   => 'admin123',
            ],
            [
                'nom'    => 'Ben Ali',
                'prenom' => 'Mohamed',
                'email'  => 'agriculteur@flahasmart.com',
                'role'   => 'AGRICULTEUR',
                'pass'   => 'agri123',
            ],
            [
                'nom'    => 'Trabelsi',
                'prenom' => 'Sana',
                'email'  => 'client@flahasmart.com',
                'role'   => 'CLIENT',
                'pass'   => 'client123',
            ],
        ];

        foreach ($usersData as $data) {
            $user = new Users();
            $user->setNom($data['nom']);
            $user->setPrenom($data['prenom']);
            $user->setEmail($data['email']);
            $user->setRole($data['role']);
            $user->setPassword(
                $this->hasher->hashPassword($user, $data['pass'])
            );
            $manager->persist($user);
        }

        $manager->flush();
        echo "✅ Utilisateurs créés !\n";
        echo "   admin@flahasmart.com       / admin123\n";
        echo "   agriculteur@flahasmart.com / agri123\n";
        echo "   client@flahasmart.com      / client123\n";
    }
}