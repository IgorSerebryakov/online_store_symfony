<?php

namespace App\User\Service;

use App\User\DTO\CreateUserDTO;
use App\User\DTO\UpdateUserDTO;
use App\User\Entity\User;
use App\User\Repository\UserRepository;
use App\User\Validator\UserValidator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private UserRepository              $userRepository,
        private UserValidator               $userValidator,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function list(): array
    {
        return $this->userRepository->findAll();
    }

    public function create(CreateUserDTO $createUserDTO): User
    {
        $this->userValidator->validateEmail($createUserDTO->email);

        $user = User::create(
            $createUserDTO->email,
            $createUserDTO->phone,
            $createUserDTO->roles
        );

        $user->setPassword($createUserDTO->password, $this->passwordHasher);

        $this->userRepository->add($user);

        return $user;
    }

    public function update(UpdateUserDTO $updateUserDTO, User $user): User
    {
        if ($user->getEmail() !== $updateUserDTO->email) {
            $this->userValidator->validateEmail($updateUserDTO->email);
        }

        $user->update(
            $updateUserDTO->email,
            $updateUserDTO->phone,
            $updateUserDTO->roles
        );

        $user->setPassword($updateUserDTO->password, $this->passwordHasher);

        $this->userRepository->add($user);

        return $user;
    }
}