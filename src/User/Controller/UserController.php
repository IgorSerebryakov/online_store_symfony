<?php

namespace App\User\Controller;

use App\Greeting\GreetingInterface;
use App\GreetingServiceFactory;
use App\User\DTO\CreateUserDTO;
use App\User\DTO\UpdateUserDTO;
use App\User\Entity\User;
use App\User\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    private GreetingInterface $greetingService;
    public function __construct(private UserService $userService, private GreetingServiceFactory $factory)
    {}

    #[Route(path: '/users', name: 'list_users', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $users = $this->userService->list();

        return $this->json($users, Response::HTTP_OK);
    }

    #[IsGranted(
        'ROLE_USER_ADMIN',
        message: 'Пользователь должен обладать правами ROLE_USER_ADMIN'
    )]
    #[Route(path: '/user', name: 'create_user', methods: ['POST'])]
    public function create(
        #[MapRequestPayload(validationFailedStatusCode: 400)] CreateUserDTO $dto,
    ): JsonResponse
    {
        $user = $this->userService->create($dto);

        return $this->json($user, Response::HTTP_CREATED);
    }

    #[Route(path: '/user/{id}', name: 'update_user', methods: ['PUT'])]
    public function update(
        #[MapRequestPayload(validationFailedStatusCode: 400)] UpdateUserDTO $dto,
        User $user
    ): JsonResponse
    {
        $user = $this->userService->update($dto, $user);

        return $this->json($user, Response::HTTP_OK);
    }

    #[Route(path: '/greetingFromMail', name: 'greeting_mail', methods: ['GET'])]
    public function greetingFromMail()
    {
        $this->greetingService = $this->factory->create('mail');
        dd($this->greetingService->hello());
    }

    #[Route(path: '/greetingFromSms', name: 'greeting_sms', methods: ['GET'])]
    public function greetingFromSms()
    {
        $this->greetingService = $this->factory->create('sms');
        dd($this->greetingService->hello());
    }
}