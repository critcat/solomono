<?php

namespace App\Controller;

use App\Handlers\GetCurrentCategoryAndProductsHandler;
use App\Handlers\GetProductByIdHandler;
use App\Handlers\GetCategoriesAndProductsHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
	/**
     * @Route("", name="app-main")
     */
    public function index(Request $request, GetCategoriesAndProductsHandler $handler): Response
	{
		$categoryId = $request->query->get('c') ?: 0;
		$sort = $request->query->get('sort') ?? '';

		$response = $handler->run($categoryId, $sort);

		return $this->render('base.html.twig', array_merge(
			[
				'currentCategoryId' => $categoryId,
				'currentSort' => $sort,
			],
			$response
		));
    }

	/**
	 * @Route("/category/{id}/{sort}", name="category-by-id", methods={"GET"})
	 */
	public function showCategory(int $id, GetCurrentCategoryAndProductsHandler $handler, string $sort = ''): JsonResponse
	{
		return $this->json($handler->run($id, $sort));
	}

	/**
	 * @Route("/product/{id}", name="product-details", requirements={"id"="\d+"}, methods={"GET"})
	 */
	public function showOneProduct(int $id, GetProductByIdHandler $handler): JsonResponse
	{
		return $this->json($handler->run($id));
	}
}
