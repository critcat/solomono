<?php

namespace App\Handlers;

use App\Fetchers\CategoriesFetcher;

class BuildCategoriesArrayHandler
{
	protected CategoriesFetcher $fetcher;
	private array $categories = [];

	public function __construct(CategoriesFetcher $fetcher)
	{
		$this->fetcher = $fetcher;
	}

	/**
	 * @throws \Doctrine\DBAL\Exception
	 */
	public function run()
	{
		$this->categories = $this->fetcher->getAllCategoriesFromDatabase();

		return $this->buildCategoriesArray();
	}

	private function buildCategoriesArray(int $parentId = 0)
	{
		foreach ($this->categories as $category) {
			if ($category['parent_id'] == $parentId) {
				$result[$category['categories_id']] = $this->buildCategoriesArray($category['categories_id']);
			}
		}

		return $result ?? $parentId;
	}
}