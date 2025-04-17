<?php

namespace App\DTO\Product;

class CreateProductDto
{
    public function __construct(
        public string $name,

        public ?string $description,

        public string $price,

        public int $quantity = 0,

        public bool $isActive = false
    ) {}
}