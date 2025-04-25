<?php

namespace App\User\Service;

use App\User\DTO\CreateUserDTO;
use App\User\Entity\User;
use App\User\Repository\UserRepository;

class CreateUserService
{
    public function __construct(private UserRepository $userRepository) {}

    public function create(CreateUserDTO $createUserDTO): User
    {
        $user = User::create(
            $createUserDTO->email,
            $createUserDTO->password,
            $createUserDTO->phone
        );

        $this->userRepository->add($user);

        return $user;
    }
}