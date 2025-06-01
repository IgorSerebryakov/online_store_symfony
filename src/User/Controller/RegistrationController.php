<?php

namespace App\User\Controller;

use App\User\DTO\CreateUserDTO;
use App\User\DTO\RegisterUserDTO;
use App\User\Entity\User;
use App\User\Service\RegistrationService;
use App\User\Service\UserService;
use App\User\ValueObject\ConfirmationCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        private RegistrationService $registrationService,
        private UserService $userService
    ) {}

    #[Route('/register', name: 'registration', methods: ['POST'])]
    public function register(
        #[MapRequestPayload(validationFailedStatusCode: 400)] RegisterUserDTO $registerUserDTO
    )
    {
        $user = $this->userService->create(new CreateUserDTO(
            $registerUserDTO->email,
            $registerUserDTO->password,
            $registerUserDTO->phone
        ));

        return $this->json($user, Response::HTTP_OK);
    }

    #TODO подумать, как переделать без id
    #[Route('/{id}/sendConfirmationCode', name: 'send_confirmation_code', methods: ['POST'])]
    public function sendConfirmationCode(User $user): JsonResponse
    {
        $code = $this->registrationService->sendConfirmationCode($user);

        return $this->json($code, Response::HTTP_OK);
    }

    #TODO подумать, как переделать без id
    #[Route('/{id}/confirm', name: 'confirm_registration', methods: ['POST'])]
    public function confirm(
        Request $request,
        User $user
    ): JsonResponse
    {
        $confirmationCode = new ConfirmationCode($request->getPayload()->get('code'));

        $this->registrationService->checkConfirmationCode($user, $confirmationCode);

        return $this->json($user, Response::HTTP_OK);
    }
}