<?php

namespace App\Category\Service;

use App\Category\DTO\UpdateCategoryDTO;
use App\Category\Entity\Category;
use App\Category\Repository\CategoryRepository;

class UpdateCategoryService
{
    public function __construct(private CategoryRepository $categoryRepository)
    {}

    public function update(Category $category, UpdateCategoryDTO $dto): Category
    {
        $category::update(
            $category,
            $dto->name,
            $dto->description,
            $dto->isActive
        );

        $this->categoryRepository->add($category);

        return $category;
    }
}