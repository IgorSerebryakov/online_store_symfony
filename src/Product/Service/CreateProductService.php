<?php

namespace App\Product\Service;

use App\Category\Repository\CategoryRepository;
use App\Product\DTO\CreateProductDto;
use App\Product\Entity\Product;
use App\Product\Repository\ProductRepository;

readonly class CreateProductService
{
    public function __construct(
        private ProductRepository $repository,
        private CategoryRepository $categoryRepository,
    ) {}

    public function create(CreateProductDto $createProductDto): Product
    {
        if (null === $createProductDto->categoryId) {
            $category = null;
        } else {
            $category = $this->categoryRepository->find($createProductDto->categoryId);
        }

        $product = Product::create(
            $createProductDto->name,
            $createProductDto->description,
            $createProductDto->price,
            $createProductDto->quantity,
            $createProductDto->isActive,
            $category
        );

        $this->repository->add($product);

        return $product;
    }
}