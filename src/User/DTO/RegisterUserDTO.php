<?php

namespace App\User\DTO;

class RegisterUserDTO
{
    public string $email;

    public string $password;

    public ?string $phone;
}