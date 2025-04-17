<?php

namespace App\Service\Product;

use App\DTO\Product\UpdateProductDto;
use App\Entity\Product;
use App\Repository\ProductRepository;

readonly class UpdateProductService
{
    public function __construct(
        private ProductRepository $repository,
    ) {}

    public function update(Product $product, UpdateProductDto $updateProductDto): Product
    {
        $product::update(
            $product,
            $updateProductDto->name,
            $updateProductDto->description,
            $updateProductDto->price,
            $updateProductDto->quantity,
            $updateProductDto->isActive
        );

        $this->repository->add($product);

        return $product;
    }
}