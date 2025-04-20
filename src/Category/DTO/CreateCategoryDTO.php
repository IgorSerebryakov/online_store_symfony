<?php

namespace App\Category\DTO;

class CreateCategoryDTO
{
    public string $name;

    public ?string $description;

    public bool $isActive;
}