<?php

namespace App\Product\Service;

use App\Product\Repository\ProductRepository;

class SkuGenerator
{
    public function __construct(private ProductRepository $productRepository)
    {}

    public function generate(): int
    {
        do {
            $sku = random_int(100000, 999999);

            $exists = $this->productRepository->findBySku($sku);
        } while ($exists);

        return $sku;
    }
}