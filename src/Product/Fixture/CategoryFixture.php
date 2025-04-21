<?php

namespace App\Product\Fixture;

use App\Product\DTO\CreateProductDto;
use App\Product\Entity\Product;
use App\Product\Service\CreateProductService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    public function __construct(private CreateProductService $createProductService)
    {}

    public function load(ObjectManager $manager): void
    {
        $conn = $manager->getConnection();
        $conn->beginTransaction();

        try{
            for ($i = 0; $i <= 100000; $i++) {
                $conn->insert('product', [
                    'name' => "Продукт-$i",
                    'slug' => "product-$i",
                    'description' => "Описание продукта-$i",
                    'price' => 1000 + $i,
                    'old_price' => null,
                    'sku' => 100000 + $i,
                    'quantity' => 1,
                    'is_active' => true,
                    'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'updated_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                ]);

                if ($i % 1000 === 0) {
                    $conn->commit();
                    $conn->beginTransaction();
                }
            }

            $conn->commit();
        } catch (\Exception $exception) {
            $conn->rollBack();
            throw $exception;
        }

    }
}