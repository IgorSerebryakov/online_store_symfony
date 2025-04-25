<?php

namespace App\User\Controller;

use App\User\DTO\CreateUserDTO;
use App\User\Service\CreateUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class CreateUserAction extends AbstractController
{
    #[Route(name: 'create_user', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload(validationFailedStatusCode: 400)] CreateUserDTO     $dto,
                                                              CreateUserService $createUserService
    ): JsonResponse
    {
        $createUserService->create($dto);

        return new JsonResponse([], Response::HTTP_CREATED);
    }
}