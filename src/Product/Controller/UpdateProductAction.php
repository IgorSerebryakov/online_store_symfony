<?php

namespace App\Product\Controller;

use App\Product\DTO\UpdateProductDto;
use App\Product\Entity\Product;
use App\Product\Service\UpdateProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product')]
class UpdateProductAction extends AbstractController
{
    #[Route('/{slug}', name: 'product_update', methods: ['PATCH'])]
    public function __invoke(
        Request              $request,
        Product              $product,
        UpdateProductService $service
    ): JsonResponse
    {
        $updateProductDto = new UpdateProductDto(
            $product->getName(),
            $product->getDescription(),
            $product->getPrice(),
            $product->getQuantity(),
            $product->isActive(),
            $product->getCategory()?->getId()
        );

        foreach ($request->toArray() as $property => $value) {
            $updateProductDto->{$property} = $value;
        }

        $service->update($product, $updateProductDto);

        return $this->json(['success' => true], Response::HTTP_CREATED);
    }
}