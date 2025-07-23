<?php

namespace App\Category\Controller;

use App\Category\DTO\CreateCategoryDTO;
use App\Category\Entity\Category;
use App\Category\Repository\CategoryRepository;
use App\Category\Service\CreateCategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category')]
class ShowCategoryAction extends AbstractController
{
    #[Route('/{id}', name: 'category_show', methods: ['GET'])]
    public function __invoke(Category $category): JsonResponse
    {
        return $this->json($category, Response::HTTP_CREATED, [], ['groups' => ['category_show']]);
    }
}