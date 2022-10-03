<?php

namespace App\Controller;

use App\Handlers\BuildCategoriesArrayHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesArrayController extends AbstractController
{
	/**
	 * @Route("/categories/array", name="app_categories_array")
	 * @throws \Doctrine\DBAL\Exception
	 */
    public function buildCategoriesArray(BuildCategoriesArrayHandler $handler)
    {
		$timeStart = microtime(true);
		$categories = $handler->run();

		dump($categories);
		dd(microtime(true) - $timeStart);
    }
}
