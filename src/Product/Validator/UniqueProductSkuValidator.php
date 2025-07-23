<?php

namespace App\Product\Validator;

use App\Product\Entity\Product;
use App\Product\Repository\ProductRepository;
use Webmozart\Assert\Assert;

class UniqueProductSkuValidator
{
    public function __construct(private ProductRepository $productRepository)
    {}

    public function validate(string $sku, Product $product): void
    {
        $existingProduct = $this->productRepository->findBySku($sku);

        if (!is_null($existingProduct)) {
            $existingSku = $existingProduct->getSku();

            Assert::notEq(
                $existingSku,
                $product->getSlug(),
                "Sku '$existingSku' уже существует.");
        }
    }
}