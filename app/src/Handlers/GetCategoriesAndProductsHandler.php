<?php

namespace App\Handlers;

use App\Repository\CategoryRepository;

class GetCategoriesAndProductsHandler
{
	protected CategoryRepository $categoryRepository;
	protected GetCurrentCategoryAndProductsHandler $currentCategoryAndProductsHandler;

	public function __construct(CategoryRepository $categoryRepository, GetCurrentCategoryAndProductsHandler $currentCategoryAndProductsHandler)
	{
		$this->categoryRepository = $categoryRepository;
		$this->currentCategoryAndProductsHandler = $currentCategoryAndProductsHandler;
	}

	public function run(int $categoryId = 0, string $sort = ''): array
	{
		$categories = $this->categoryRepository->findAll();
		$currentCategoryWithProducts = $this->currentCategoryAndProductsHandler->run($categoryId, $sort);

		return array_merge(['categories' => $categories], $currentCategoryWithProducts);
	}
}