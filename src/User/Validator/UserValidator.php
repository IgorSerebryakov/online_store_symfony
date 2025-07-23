<?php

namespace App\User\Validator;

use App\User\Entity\User;
use App\User\Repository\UserRepository;
use Webmozart\Assert\Assert;

class UserValidator
{
    public function __construct(private UserRepository $userRepository)
    {}

    public function validateEmail(string $email): self
    {
        Assert::true(
            empty($this->userRepository->findByEmail($email)),
            "Email '$email' уже существует.");

        return $this;
    }
}