<?php

namespace App\Product\DTO;

class UpdateProductDto
{
    public function __construct(
        public string $name,

        public ?string $description,

        public string $price,

        public int $quantity,

        public bool $isActive,

        public ?int $categoryId,
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'isActive' => $this->isActive,
            'category' => $this->categoryId,
        ];
    }
}