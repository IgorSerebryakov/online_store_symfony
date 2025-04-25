<?php

namespace App\Category\Controller;

use App\Category\DTO\UpdateCategoryDTO;
use App\Category\Entity\Category;
use App\Category\Service\UpdateCategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category')]
class UpdateCategoryAction extends AbstractController
{
    #[Route('/{slug}', name: 'category_update', methods: ['PATCH'])]
    public function __invoke(
        Request               $request,
        Category              $category,
        UpdateCategoryService $service
    ): JsonResponse
    {
        $updateCategoryDto = new UpdateCategoryDTO(
            $category->getName(),
            $category->getDescription(),
            $category->isActive()
        );

        foreach ($request->toArray() as $property => $value) {
            $updateCategoryDto->{$property} = $value;
        }

        $service->update($category, $updateCategoryDto);

        return $this->json(['success' => true], Response::HTTP_OK);
    }
}