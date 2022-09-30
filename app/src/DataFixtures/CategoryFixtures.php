<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
	const REFERENCE = 'category';

    public function load(ObjectManager $manager): void
    {
		$data = [
			'Побутова техніка',
			'Телевізори',
			'Смартфони',
			'Ноутбуки',
		];

		for ($i = 0, $n = count($data); $i < $n; $i++) {
			$category = new Category();
			$category->setName($data[$i]);
			$manager->persist($category);
			$this->addReference(self::REFERENCE . '_' . $i, $category);
		}

        $manager->flush();
    }
}
