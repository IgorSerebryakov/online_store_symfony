<?php

namespace App\Product\Service;

use App\Category\Repository\CategoryRepository;
use App\Product\DTO\UpdateProductDto;
use App\Product\Entity\Product;
use App\Product\Repository\ProductRepository;

readonly class UpdateProductService
{
    public function __construct(
        private ProductRepository $repository,
        private CategoryRepository $categoryRepository,
    ) {}

    public function update(Product $product, UpdateProductDto $updateProductDto): Product
    {
        if (null === $updateProductDto->categoryId) {
            $category = null;
        } else {
            $category = $this->categoryRepository->find($updateProductDto->categoryId);
        }

        $product::update(
            $product,
            $updateProductDto->name,
            $updateProductDto->description,
            $updateProductDto->price,
            $updateProductDto->quantity,
            $updateProductDto->isActive,
            $category
        );

        $this->repository->add($product);

        return $product;
    }
}