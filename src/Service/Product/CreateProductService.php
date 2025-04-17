<?php

namespace App\Service\Product;

use App\DTO\Product\CreateProductDto;
use App\Entity\Product;
use App\Factory\Product\ProductFactory;
use App\Repository\ProductRepository;

readonly class CreateProductService
{
    public function __construct(
        private ProductRepository $repository,
    ) {}

    public function create(CreateProductDto $createProductDto): Product
    {
        $product = Product::create(
            $createProductDto->name,
            $createProductDto->description,
            $createProductDto->price,
            $createProductDto->quantity,
            $createProductDto->isActive
        );

        $this->repository->add($product);

        return $product;
    }
}