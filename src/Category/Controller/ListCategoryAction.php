<?php

namespace App\Category\Controller;

use App\Category\DTO\CreateCategoryDTO;
use App\Category\Repository\CategoryRepository;
use App\Category\Service\CreateCategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categories')]
class ListCategoryAction extends AbstractController
{
    public function __construct(private CategoryRepository $categoryRepository) {}

    #[Route(name: 'category_list', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $categories = $this->categoryRepository->findAll();

        return $this->json($categories, Response::HTTP_CREATED, [], ['groups' => ['category_show']]);
    }
}