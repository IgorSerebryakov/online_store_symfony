<?php

namespace App\User\Controller;

use App\User\DTO\CreateUserDTO;
use App\User\DTO\UpdateUserDTO;
use App\User\Entity\User;
use App\User\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    public function __construct(private UserService $userService)
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
}