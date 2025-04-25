<?php

namespace App\Category\DTO;

class UpdateCategoryDTO
{
    public function __construct(
        public string $name,
        public ?string $description,
        public bool $isActive
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'isActive' => $this->isActive,
        ];
    }
}