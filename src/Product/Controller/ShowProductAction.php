<?php

namespace App\Product\Controller;

use App\Product\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product')]
class ShowProductAction extends AbstractController
{
    #[Route('/{id}', name: 'showProduct', methods: ['GET'])]
    public function __invoke(
        Product $product,
    ): JsonResponse
    {
        return $this->json($product, Response::HTTP_CREATED, [], ['groups' => ['product_show']]);
    }
}