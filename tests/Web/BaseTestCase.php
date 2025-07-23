<?php

namespace App\Tests\Web;

use App\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseTestCase extends WebTestCase
{
    protected static ?EntityManagerInterface $entityManager;
    protected static KernelBrowser $client;

    protected function setUp(): void
    {
        self::$client = self::createClient();
        self::$entityManager = self::$client->getContainer()->get('doctrine.orm.entity_manager');
    }

    protected static function createAuthorizedClient(User $user): KernelBrowser
    {
        self::$client->jsonRequest(
            'POST',
            '/api/login',
            [
                'username' => $user->getEmail(),
                'password' => $user->getPassword(),
            ]
        );

        $data = json_decode(self::$client->getResponse()->getContent(), true);

        self::$client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return self::$client;
    }
}