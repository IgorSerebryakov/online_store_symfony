<?php

namespace App\User\Validator;

use App\User\Entity\User;
use App\User\Repository\UserRepository;
use Webmozart\Assert\Assert;

class UniqueUserEmailValidator
{
    public function __construct(private UserRepository $userRepository)
    {}

    public function validate(string $email, User $user): void
    {
        $existingUser = $this->userRepository->findByEmail($email);

        if (!is_null($existingUser) && $existingUser !== $user) {
            $existingEmail = $existingUser->getEmail();

            Assert::notEq(
                $existingEmail,
                $user->getEmail(),
                "Email '$existingEmail' уже существует.");
        }
    }
}