<?php

namespace App\Product\Service;

use App\Category\Repository\CategoryRepository;
use App\Product\DTO\UpdateProductDto;
use App\Product\Entity\Product;
use App\Product\Repository\ProductRepository;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

readonly class UpdateProductService
{
    public function __construct(
        private ProductRepository      $repository,
        private CategoryRepository     $categoryRepository,
        private TagAwareCacheInterface $cache,
    ) {}

    public function update(Product $product, UpdateProductDto $updateProductDto): Product
    {
        $product::update(
            $product,
            $updateProductDto->name,
            $updateProductDto->description,
            $updateProductDto->price,
            $updateProductDto->quantity,
            $updateProductDto->isActive,
        );

        if (null === $updateProductDto->categoryId) {
            $category = null;
        } else {
            $category = $this->categoryRepository->find($updateProductDto->categoryId);
        }

        $this->repository->addProduct($product);

        $this->cache->invalidateTags(['products']);

        return $product;
    }
}