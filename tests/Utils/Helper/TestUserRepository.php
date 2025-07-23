<?php

namespace App\Tests\Utils\Helper;

use App\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TestUserRepository extends WebTestCase
{
    const TEST_ADMIN = [
        'username' => 'admin@test.ru',
        'password' => 'password',
    ];



    public static function create(array $rules): User
    {
        /** @var EntityManagerInterface $em */
        $em = static::getContainer()->get('doctrine.orm.entity_manager');

        /** @var UserPasswordHasherInterface $passwordHasher */
        $passwordHasher = static::getContainer()->get('security.user_password_hasher');

        $user = User::create(self::TEST_ADMIN, null, $rules);

        $user->setPassword(self::$password, $passwordHasher);

        $em->persist($user);
        $em->flush();

        return $user;
    }

    public static function findUser(): ?User
    {
        /** @var EntityManagerInterface $em */
        $em = static::getContainer()->get('doctrine.orm.entity_manager');

        $user = $em->getRepository(User::class)->findOneBy(['email' => self::$username]);

        return $user;
    }

    public static function delete(string $id): void
    {
        /** @var EntityManagerInterface $em */
        $em = static::getContainer()->get('doctrine.orm.entity_manager');

        $user = $em->getRepository(User::class)->find($id);

        $em->remove($user);
        $em->flush();
    }
}
