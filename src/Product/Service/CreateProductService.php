<?php

namespace App\Product\Service;

use App\Category\Repository\CategoryRepository;
use App\Product\DTO\CreateProductDto;
use App\Product\Entity\Product;
use App\Product\Repository\ProductRepository;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

readonly class CreateProductService
{
    public function __construct(
        private ProductRepository      $repository,
        private CategoryRepository     $categoryRepository,
    ) {}

    public function create(CreateProductDto $createProductDto): Product
    {
        $product = Product::create(
            $createProductDto->name,
            $createProductDto->description,
            $createProductDto->price,
            $createProductDto->quantity,
            $createProductDto->isActive,
        );

        if (null !== $createProductDto->categoryId) {
            $category = $this->categoryRepository->find($createProductDto->categoryId);
            $product->addCategory($category);
        }

        $this->repository->addProduct($product);

        return $product;
    }
}