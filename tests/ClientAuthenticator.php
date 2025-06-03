<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientAuthenticator extends WebTestCase
{
    public function __construct(private KernelBrowser $client)
    {
        parent::__construct('ClientAuthenticator');
    }
    public function authenticate(string $username, string $password): KernelBrowser
    {
        $this->client->jsonRequest(
            'POST',
            '/api/login',
            [
                'username' => $username,
                'password' => $password,
            ]
        );

        $data = json_decode($this->client->getResponse()->getContent(), true);

        $this->client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $this->client;
    }
}