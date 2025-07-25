<?php

namespace App\Product\EventListener;

use App\Product\Entity\Product;
use App\Product\Service\SkuGenerator;
use App\Product\Validator\UniqueProductSkuValidator;
use App\Product\Validator\UniqueProductSlugValidator;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsEntityListener(event: Events::prePersist, entity: Product::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Product::class)]
readonly class ProductEntityListener
{
    public function __construct(
        private SluggerInterface           $slugger,
        private SkuGenerator               $skuGenerator,
        private UniqueProductSlugValidator $uniqueProductSlugValidator,
        private UniqueProductSkuValidator  $uniqueProductSkuValidator,
        private TagAwareCacheInterface     $cache
    )
    {}

    public function prePersist(Product $product, LifecycleEventArgs $args): void
    {
        $slug = $product->computeSlug($this->slugger);
        $sku = $product->computeSku($this->skuGenerator);

        $this->uniqueProductSlugValidator->validate($slug, $product);
        $this->uniqueProductSkuValidator->validate($sku, $product);

        $this->cache->invalidateTags(['products']);
    }

    public function preUpdate(Product $product, LifecycleEventArgs $args): void
    {
        $slug = $product->computeSlug($this->slugger);

        $this->uniqueProductSlugValidator->validate($slug, $product);

        $this->cache->invalidateTags(['products']);
    }
}