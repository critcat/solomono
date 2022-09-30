<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
	private array $referencesIndex = [];

	/**
	 * @throws Exception
	 */
	public function load(ObjectManager $manager): void
    {
		$productsData = $this->getData();

		foreach ($productsData as $datum) {
			$product = new Product();
			/** @var Category $category */
			$category = $this->getRandomReference(CategoryFixtures::REFERENCE);
			$product
				->setName($datum['name'])
				->setPrice($datum['price'])
				->setCreatedAt(new DateTime('2022-0' . rand(1, 9) . '-' . rand(1, 28)))
				->setCategory($category)
			;
			$manager->persist($product);
		}


        $manager->flush();
    }

	public function getDependencies(): array
	{
		return [
			CategoryFixtures::class,
		];
	}

	/**
	 * @throws Exception
	 */
	private function getRandomReference(string $className): object
	{
		if (!isset($this->referencesIndex[$className])) {
			$this->referencesIndex[$className] = [];
			foreach ($this->referenceRepository->getReferences() as $key => $ref) {
				if (strpos($key, $className . '_') === 0) {
					$this->referencesIndex[$className][] = $key;
				}
			}
		}

		if (empty($this->referencesIndex[$className])) {
			throw new Exception(sprintf('Cannot find any references for class "%s"', $className));
		}

		$randomIndex = rand(0, count($this->referencesIndex[$className]) - 1);
		$randomReferenceKey = $this->referencesIndex[$className][$randomIndex];

		return $this->getReference($randomReferenceKey);
	}

	private function getData(): array
	{
		return [
			[
				'name' => 'Apple iPhone 14 Pro 128GB',
				'price' => 6142200,
			],
			[
				'name' => 'Xiaomi Redmi Note 11 6/128GB',
				'price' => 913100,
			],
			[
				'name' => 'Motorola Moto G32 6/128GB',
				'price' => 746800,
			],
			[
				'name' => 'Apple iPhone 11 128GB',
				'price' => 2534000,
			],
			[
				'name' => 'Google Pixel 6 8/128GB',
				'price' => 2453200,
			],
			[
				'name' => 'Samsung Galaxy S21 FE 5G 6/128GB',
				'price' => 2508800,
			],
			[
				'name' => 'OnePlus 9RT 12/256GB',
				'price' => 2217100,
			],
			[
				'name' => 'LG OLED55C1',
				'price' => 5109400,
			],
			[
				'name' => 'Xiaomi Mi TV P1 43"',
				'price' => 1502900,
			],
			[
				'name' => 'Samsung QE55Q60A',
				'price' => 2965700,
			],
			[
				'name' => 'Sony XR-55X90J',
				'price' => 4304200,
			],
			[
				'name' => 'Philips 55PUS9206',
				'price' => 3556500,
			],
			[
				'name' => 'AKAI UA32HD22T2S',
				'price' => 630200,
			],
			[
				'name' => 'Whirlpool FWDG86148B EU',
				'price' => 2126800,
			],
			[
				'name' => 'Samsung WW70T3020BW',
				'price' => 1661100,
			],
			[
				'name' => 'Bosch WAN2427GPL',
				'price' => 1671600,
			],
			[
				'name' => 'Indesit OMTWSA 51052 W',
				'price' => 984200,
			],
			[
				'name' => 'Apple MacBook Air 13"',
				'price' => 4374800,
			],
			[
				'name' => 'Acer Nitro 5 AN515-57',
				'price' => 3857100,
			],
			[
				'name' => 'GIGABYTE G5 KD',
				'price' => 4126000,
			],
		];
	}
}
