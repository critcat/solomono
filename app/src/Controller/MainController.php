<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Response\ProductResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
	protected CategoryRepository $categoryRepository;
	protected ProductRepository $productRepository;

	public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository)
	{
		$this->categoryRepository = $categoryRepository;
		$this->productRepository = $productRepository;
	}

	/**
     * @Route("", name="app-main")
     */
    public function index(Request $request): Response
	{
		$categoryId = $request->query->get('c') ?: 0;
		$categories = $this->categoryRepository->findAll();
		$currentCategory = null;

		if ($categoryId) {
			$currentCategory = $this->categoryRepository->find($categoryId);
			$products = $this->productRepository->findBy(['category' => $currentCategory]);
		} else {
			$products = $this->productRepository->findAll();
		}

		return $this->render('base.html.twig', [
			'categories' => $categories,
			'currentCategory' => $currentCategory,
			'products' => $products,
		]);
    }

	/**
	 * @Route("/category/{id}", name="category-by-id", requirements={"id"="\d+"}, methods={"GET"})
	 */
	public function showCategory(int $id): JsonResponse
	{
		$category = $this->categoryRepository->find($id);
		$products = $this->productRepository->findBy(['category' => $category]);

		return $this->json([
			'category' => [
				'id' => $category->getId(),
				'name' => $category->getName(),
				'products' => array_map(
					fn (Product $product) => new ProductResponse($product),
					$products
				),
			],
		]);
	}


	/**
	 * @Route("/product/{id}", name="product-details", requirements={"id"="\d+"}, methods={"GET"})
	 */
	public function showOneProduct(int $id): JsonResponse
	{
		$product = $this->productRepository->find($id);
		$response = new ProductResponse($product);

		return $this->json($response);
	}
}
