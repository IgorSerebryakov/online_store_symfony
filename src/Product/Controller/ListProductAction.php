<?php

namespace App\Product\Controller;
ini_set('memory_limit', '2048M');

use App\Product\Repository\ProductRepository;
use App\Product\Service\ListProductService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

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

        return $this->json($products, Response::HTTP_CREATED, [], ['groups' => ['product_show']]);
    }
}