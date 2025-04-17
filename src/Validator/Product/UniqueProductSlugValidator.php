<?php

namespace App\Validator\Product;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Webmozart\Assert\Assert;

class UniqueProductSlugValidator
{
    public function __construct(private ProductRepository $productRepository)
    {}

    public function validate(string $slug, Product $product): void
    {
        $existingProduct = $this->productRepository->findBySlug($slug);

        if (!is_null($existingProduct) && $existingProduct->getId() !== $product->getId()) {
            $existingSlug = $existingProduct->getSlug();

            Assert::notEq(
                $existingSlug,
                $product->getSlug(),
                "Slug '$existingSlug' уже существует.");
        }
    }
}