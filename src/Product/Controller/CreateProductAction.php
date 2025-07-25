<?php

namespace App\Product\Controller;

use App\Product\DTO\CreateProductDto;
use App\Product\Service\CreateProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product')]
class CreateProductAction extends AbstractController
{
    #[Route('/create', name: 'createProduct', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload(validationFailedStatusCode: 400)] CreateProductDto $createProductDto,
        CreateProductService $service
    ): JsonResponse
    {
        $service->create($createProductDto);

        return $this->json(['success' => true], Response::HTTP_CREATED);
    }
}