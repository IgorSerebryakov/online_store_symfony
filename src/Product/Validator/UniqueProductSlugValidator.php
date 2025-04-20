<?php

namespace App\Product\Validator;

use App\Product\Entity\Product;
use App\Product\Repository\ProductRepository;
use Webmozart\Assert\Assert;

class UniqueProductSlugValidator
{
    public function __construct(private ProductRepository $productRepository)
    {}

    public function validate(string $slug, Product $product): void
    {
        $existingProduct = $this->productRepository->findBySlug($slug);

        if (!is_null($existingProduct) && $existingProduct !== $product) {
            $existingSlug = $existingProduct->getSlug();

            Assert::notEq(
                $existingSlug,
                $product->getSlug(),
                "Slug '$existingSlug' уже существует.");
        }
    }
}