<?php

namespace App\Tests\Utils\Helper;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class ClientAuthenticator
{
    public static function authenticate(KernelBrowser $client): KernelBrowser
    {
        $client->jsonRequest(
            'POST',
            '/api/login',
            [
                'username' => TestUserRepository::$username,
                'password' => TestUserRepository::$password,
            ]
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }
}