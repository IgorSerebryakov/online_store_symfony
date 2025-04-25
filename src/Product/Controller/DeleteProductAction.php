<?php

namespace App\Product\Controller;

use App\Product\DTO\UpdateProductDto;
use App\Product\Entity\Product;
use App\Product\Repository\ProductRepository;
use App\Product\Service\DeleteProductService;
use App\Product\Service\UpdateProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product')]
class DeleteProductAction extends AbstractController
{
    #[Route('/{slug}', name: 'product_delete', methods: ['DELETE'])]
    public function __invoke(
        Product              $product,
        DeleteProductService $service
    ): JsonResponse
    {
        $service->delete($product);

        return $this->json(['success' => true], Response::HTTP_NO_CONTENT);
    }
}