<?php

namespace App\Validator\Product;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Webmozart\Assert\Assert;

class UniqueProductSkuValidator
{
    public function __construct(private ProductRepository $productRepository)
    {}

    public function validate(string $slug, Product $product): void
    {
        $existingProduct = $this->productRepository->findBySku($slug);

        if (!is_null($existingProduct)) {
            $existingSku = $existingProduct->getSku();

            Assert::notEq(
                $existingSku,
                $product->getSlug(),
                "Sku '$existingSku' уже существует.");
        }
    }
}