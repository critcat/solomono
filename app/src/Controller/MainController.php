<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("", name="app_main")
     */
    public function index(CategoryRepository $repository): JsonResponse
    {
		$categories = $repository->findAll();

		foreach ($categories as $category) {
			dump($category->getId(), $category->getName(), $category->getProducts()->count());
		}



		return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MainController.php',
        ]);
    }
}
