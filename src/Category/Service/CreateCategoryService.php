<?php

namespace App\Category\Service;

use App\Category\DTO\CreateCategoryDTO;
use App\Category\Entity\Category;
use App\Category\Repository\CategoryRepository;

class CreateCategoryService
{
    public function __construct(private CategoryRepository $categoryRepository)
    {}

    public function create(CreateCategoryDTO $createCategoryDto): Category
    {
        $category = Category::create(
            $createCategoryDto->name,
            $createCategoryDto->description,
            $createCategoryDto->isActive
        );

        $this->categoryRepository->add($category);

        return $category;
    }
}