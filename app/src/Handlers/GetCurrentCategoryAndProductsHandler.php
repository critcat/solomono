<?php

namespace App\Handlers;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Response\CategoryResponse;
use App\Response\ProductResponse;

class GetCurrentCategoryAndProductsHandler
{
	protected CategoryRepository $categoryRepository;
	protected ProductRepository $productRepository;

	public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository)
	{
		$this->categoryRepository = $categoryRepository;
		$this->productRepository = $productRepository;
	}

	public function run(int $categoryId = 0, string $sort = ''): array
	{
		$currentCategory = null;

		switch ($sort) {
			case 'price':
				$orderBy = ['price' => 'ASC'];
				break;
			case 'name':
				$orderBy = ['name' => 'ASC'];
				break;
			case 'date':
			default:
				$orderBy = ['createdAt' => 'DESC'];
		}

		if ($categoryId) {
			$currentCategory = $this->categoryRepository->find($categoryId);
			$products = $this->productRepository->findBy(['category' => $currentCategory], $orderBy);
		} else {
			$products = $this->productRepository->findBy([], $orderBy);
		}

		return [
			'currentCategory' => is_null($currentCategory) ? null	: new CategoryResponse($currentCategory),
			'products' => array_map(
				fn(Product $product) => new ProductResponse($product),
				$products
			),
		];
	}
}