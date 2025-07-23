<?php

namespace App\User\DTO;

class CreateUserDTO
{
    public function __construct(
        public string $email,
        public string $password,
        public string $phone,
        public array $roles = []
    ) {}

}