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
        private TagAwareCacheInterface $cache,
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

        $this->cache->invalidateTags(['products']);

        return $product;
    }
}