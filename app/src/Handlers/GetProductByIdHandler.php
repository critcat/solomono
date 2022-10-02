<?php

namespace App\Handlers;

use App\Repository\ProductRepository;
use App\Response\ProductResponse;

class GetProductByIdHandler
{
	protected ProductRepository $repository;

	public function __construct(ProductRepository $repository)
	{
		$this->repository = $repository;
	}

	public function run(int $id): ProductResponse
	{
		$product = $this->repository->find($id);

		return new ProductResponse($product);
	}
}