<?php

namespace App\Response;

use App\Entity\Category;

class CategoryResponse
{
	public int $id;
	public string $name;

	public function __construct(Category $category)
	{
		$this->id = $category->getId();
		$this->name = $category->getName();
	}
}