<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr-FR');

        for ($i = 0; $i < 20; $i++) {
            $sex = mt_rand(0, 1);
            if ($sex === 0) {
                $type = "men";
            } else {
                $type = "women";
            }

            $user = new User();
            $user->setName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setSex($sex)
                ->setVerified(true)
                ->setAvatar('https://randomuser.me/api/portraits/' . $type . '/' . $i . 'jpg')
                ->setPassword($this->userPasswordHasher->hashPassword($user, "test123"));

            $manager->persist($user);
        }

        $admin = new User();
        $admin->setName('admin')
            ->setLastName('victor')
            ->setEmail('admin@gmail.com')
            ->setSex(0)
            ->setVerified(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setAvatar('https://randomuser.me/api/portraits/men/51.jpg')
            ->setPassword($this->userPasswordHasher->hashPassword($admin, "admintest"));

        $manager->persist($admin);

        $manager->flush();
    }
}
