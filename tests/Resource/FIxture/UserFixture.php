<?php

namespace App\Tests\Resource\FIxture;

use App\Tests\Utils\Helper\TestUserRepository;
use App\User\Entity\User;
use App\User\Enum\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    const ADMIN_REFERENCE = 'admin';

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $adminUser = User::create(
            email: TestUserRepository::TEST_ADMIN['username'],
            roles: [UserRole::SUPER_ADMIN]
        );
        $adminUser->setPassword(TestUserRepository::TEST_ADMIN['password'], $this->passwordHasher);

        $manager->persist($adminUser);
        $manager->flush();

        $this->addReference(self::ADMIN_REFERENCE, $adminUser);
    }
}