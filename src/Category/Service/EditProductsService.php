<?php

namespace App\Category\Service;

use App\Category\DTO\EditProductsDTO;
use App\Category\Entity\Category;
use App\Product\Entity\Product;
use App\Product\Repository\ProductRepository;

class EditProductsService
{
    public function __construct(private ProductRepository $productRepository)
    {}

    public function removeProducts(Category $category): void
    {
        $products = $this->productRepository->findByCategory($category);

        /** @var Product $productWithCategory */
        foreach ($products as $product) {
            $product->removeCategory();
        }

        $this->productRepository->addProducts($products);
    }

    public function addProducts(Category $category, EditProductsDTO $editProductsDTO): void
    {
        $products = $this->productRepository->findByIds($editProductsDTO->productIds);

        /** @var Product $product */
        foreach ($products as $product) {
            $product->addCategory($category);
        }

        $this->productRepository->addProducts($products);
    }
}