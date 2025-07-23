<?php

namespace App\Category\Controller;

use App\Category\DTO\EditProductsDTO;
use App\Category\Entity\Category;
use App\Category\Service\EditProductsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category')]
class EditProductsAction extends AbstractController
{
    #[Route('/{id}/products', name: 'category_edit_products', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload(validationFailedStatusCode: 400)] EditProductsDTO     $editProductsDTO,
                                                              EditProductsService $service,
                                                              Category            $category
    ): JsonResponse
    {
        $service->removeProducts($category);
        $service->addProducts($category, $editProductsDTO);

        return $this->json(['success' => true], Response::HTTP_OK);
    }
}