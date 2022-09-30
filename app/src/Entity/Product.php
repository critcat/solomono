<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private int $id;

	/**
	 * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private Category $category;

	/**
	 * @ORM\Column(type="integer")
	 */
	private int $price;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private string $name;

	/**
	 * @ORM\Column(type="date")
	 */
	private DateTime $createdAt;

	public function getId(): int
	{
		return $this->id;
	}

	public function getCategory(): Category
	{
		return $this->category;
	}

	public function setCategory(Category $category): self
	{
		$this->category = $category;

		return $this;
	}

	public function getPrice(): int
	{
		return $this->price;
	}

	public function setPrice(int $price): self
	{
		$this->price = $price;

		return $this;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getCreatedAt(): DateTime
	{
		return $this->createdAt;
	}

	public function setCreatedAt(DateTime $createdAt): self
	{
		$this->createdAt = $createdAt;

		return $this;
	}
}