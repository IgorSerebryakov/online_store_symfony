<?php

namespace App\Product\Service;

use App\Product\Repository\ProductRepository;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class ListProductService
{
    const PER_PAGE = 20;

    public function __construct(
        private ProductRepository      $productRepository,
        private TagAwareCacheInterface $cache,
    ) {}

    public function getList(int $page): array
    {
        return $this->cache->get("product_list_page=$page", function (ItemInterface $item) use ($page) {
            $products = $this->productRepository->findByPage($page, self::PER_PAGE);

            $item->set($products);

            $item->tag('products');

            return $products;
        });
    }
}