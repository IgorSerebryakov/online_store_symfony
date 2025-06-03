<?php

namespace App\Tests\Category\Controller;

use App\Category\Entity\Category;
use App\Tests\ClientAuthenticator;
use App\Tests\TestUserManager;
use App\User\Enum\UserRole;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Role\Role;
use Webmozart\Assert\InvalidArgumentException;

class CreateCategoryActionTest extends WebTestCase
{
    public function testNotCreateCategoryWithEmptyName(): void
    {
        $client = static::createClient();

        $admin = TestUserManager::findByUsername('admin@mail.com');

        if (is_null($admin)) {
            $admin = TestUserManager::create('admin@mail.com', 'admin', [UserRole::SUPER_ADMIN->value]);
        }

        $authClient = (new ClientAuthenticator($client))->authenticate('admin@mail.com', 'admin');

        $authClient->request(
            'POST',
            'http://localhost:8888/api/category',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => '',
                'description' => 'Описание',
                'isActive' => true,
            ])
        );

        // 1. Статус код 400 (Bad Request)
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

        // 2. Проверка структуры JSON-ответа
        $jsonResponse = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(
            'Наименование категории не может быть пустым. Получено: ""',
            $jsonResponse['message']
        );

        $this->assertEquals(
            Response::HTTP_BAD_REQUEST,
            $jsonResponse['code']
        );

        TestUserManager::delete($admin->getId());
    }
}
