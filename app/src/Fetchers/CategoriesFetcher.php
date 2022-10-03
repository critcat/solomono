<?php

namespace App\Fetchers;

use Doctrine\DBAL\Connection;

class CategoriesFetcher
{
	protected Connection $connection;
	private array $categories = [];

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * @throws \Doctrine\DBAL\Exception
	 */
	public function getAllCategoriesFromDatabase(): array
	{
		$stmt = $this->connection->createQueryBuilder()
			->select('c.*')
			->from('categories', 'c')
			->orderBy('c.categories_id')
			->executeQuery()
		;

		return $stmt->fetchAllAssociative();
	}
}