<?php

namespace App\Product\Controller;

use App\Product\Service\ListProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products')]
class ListProductAction extends AbstractController
{
    #[Route(name: 'listOfProducts', methods: ['GET'])]
    public function __invoke(
        ListProductService $service,
        Request $request
    ): JsonResponse
    {
        $page = $request->query->getInt('page', 1);

        $products = $service->getList($page);

        return $this->json($products, Response::HTTP_OK, [], ['groups' => ['product_show']]);
    }
}