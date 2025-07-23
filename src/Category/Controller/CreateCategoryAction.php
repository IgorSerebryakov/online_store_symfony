<?php

namespace App\Category\Controller;

use App\Category\DTO\CreateCategoryDTO;
use App\Category\Service\CreateCategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category')]
class CreateCategoryAction extends AbstractController
{
    #[Route(name: 'category_create', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload(validationFailedStatusCode: 400)] CreateCategoryDTO $createCategoryDTO,
        CreateCategoryService $service
    ): JsonResponse
    {
        $service->create($createCategoryDTO);

        return $this->json(['success' => true], Response::HTTP_CREATED);
    }
}