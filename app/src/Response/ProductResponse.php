<?php

namespace App\Response;

use App\Entity\Product;
use DateTime;

class ProductResponse
{
	public int $id;
	public string $priceFormatted;
	public string $name;
	public string $createdAt;

	public function __construct(Product $product)
	{
		$this->id = $product->getId();
		$this->priceFormatted = $product->getPriceFormatted();
		$this->name = $product->getName();
		$this->createdAt = $product->getCreatedAt()->format('d.m.Y');
	}
}