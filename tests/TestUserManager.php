<?php

namespace App\Tests;

use App\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TestUserManager extends WebTestCase
{
    public static function create(string $username, string $password, array $rules): User
    {
        # Создание пользователя с правами админа
        /** @var EntityManagerInterface $em */
        $em = static::getContainer()->get('doctrine.orm.entity_manager');

        /** @var UserPasswordHasherInterface $passwordHasher */
        $passwordHasher = static::getContainer()->get('security.user_password_hasher');

        $user = User::create($username, null, $rules);

        $user->setPassword($password, $passwordHasher);

        $em->persist($user);
        $em->flush();

        return $user;
    }

    public static function findByUsername($username): ?User
    {
        /** @var EntityManagerInterface $em */
        $em = static::getContainer()->get('doctrine.orm.entity_manager');

        $user = $em->getRepository(User::class)->findOneBy(['email' => $username]);

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
