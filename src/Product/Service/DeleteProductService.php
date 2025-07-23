<?php

namespace App\Product\Service;

use App\Product\Entity\Product;
use App\Product\Repository\ProductRepository;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class DeleteProductService
{
    public function __construct(
        private ProductRepository      $productRepository,
        private TagAwareCacheInterface $cache,
    ) {}

    public function delete(Product $product): void
    {
        $this->productRepository->remove($product);

        $this->cache->invalidateTags(['products']);
    }
}