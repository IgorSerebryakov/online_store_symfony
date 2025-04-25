<?php

namespace App\Category\Controller;

use App\Category\Entity\Category;
use App\Category\Service\DeleteCategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category')]
class DeleteCategoryAction extends AbstractController
{
    public function __construct(private DeleteCategoryService $service)
    {}

    #[Route('/{id}', name: 'category_delete', methods: ['DELETE'])]
    public function __invoke(Category $category): JsonResponse
    {
        $this->service->delete($category);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}