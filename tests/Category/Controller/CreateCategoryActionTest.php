<?php

namespace App\Tests\Category\Controller;

use App\Tests\Utils\Helper\ClientAuthenticator;
use App\Tests\Utils\Helper\TestUserRepository;
use App\Tests\Web\BaseTestCase;
use App\User\Enum\UserRole;
use Symfony\Component\HttpFoundation\Response;

class CreateCategoryActionTest extends BaseTestCase
{
    public function testNotCreateCategoryWithEmptyName(): void
    {
        // arrange
        $client = self::createAuthorizedClient(TestUserRepository::create([UserRole::SUPER_ADMIN->value]));

        $client->request(
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
    }

    public function testNotCreateCategoryWithEmptyDescription(): void
    {
        $client = static::createClient();

        $admin = TestUserRepository::findUser();

        if (is_null($admin)) {
            $admin = TestUserRepository::create([UserRole::SUPER_ADMIN->value]);
        }

        $authClient = ClientAuthenticator::authenticate($client);

        $authClient->request(
            'POST',
            'http://localhost:8888/api/category',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'Имя',
                'description' => '',
                'isActive' => true,
            ])
        );

        // 1. Статус код 400 (Bad Request)
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

        // 2. Проверка структуры JSON-ответа
        $jsonResponse = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(
            'Описание категории не может быть пустым. Получено: ""',
            $jsonResponse['message']
        );

        $this->assertEquals(
            Response::HTTP_BAD_REQUEST,
            $jsonResponse['code']
        );

        TestUserRepository::delete($admin->getId());
    }
}
