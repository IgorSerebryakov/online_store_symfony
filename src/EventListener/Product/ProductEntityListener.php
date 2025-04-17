<?php

namespace App\EventListener\Product;

use App\Entity\Product;
use App\Validator\Product\UniqueProductSkuValidator;
use App\Validator\Product\UniqueProductSlugValidator;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event: Events::prePersist, entity: Product::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Product::class)]
class ProductEntityListener
{
    public function __construct(
        private SluggerInterface           $slugger,
        private UniqueProductSlugValidator $uniqueProductSlugValidator,
        private UniqueProductSkuValidator  $uniqueProductSkuValidator
    )
    {}

    public function prePersist(Product $product, LifecycleEventArgs $args)
    {
        $slug = $product->computeSlug($this->slugger);
        $sku = $product->computeSku();

        $this->uniqueProductSlugValidator->validate($slug, $product);
        $this->uniqueProductSkuValidator->validate($sku, $product);
    }

    public function preUpdate(Product $product, LifecycleEventArgs $args)
    {
        $slug = $product->computeSlug($this->slugger);

        $this->uniqueProductSlugValidator->validate($slug, $product);
    }
}