<?php

namespace App\User\DTO;

class UpdateUserDTO
{
    public ?string $email;

    public ?string $password;

    public ?string $phone;

    public ?array $roles = [];
}