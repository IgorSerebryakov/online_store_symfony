<?php

namespace App\Category\Service;

use App\Category\DTO\EditProductsDTO;
use App\Category\Entity\Category;
use App\Category\Repository\CategoryRepository;
use App\Product\Entity\Product;
use App\Product\Repository\ProductRepository;

class DeleteCategoryService
{
    public function __construct(private CategoryRepository $categoryRepository)
    {}

    public function delete(Category $category): void
    {
        $this->categoryRepository->remove($category);
    }
}