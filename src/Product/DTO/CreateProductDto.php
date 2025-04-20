<?php

namespace App\Product\DTO;

class CreateProductDto
{
    public function __construct(
        public string $name,

        public ?string $description,

        public string $price,

        public ?int $categoryId = null,

        public int $quantity = 0,

        public bool $isActive = false,
    ) {}
}