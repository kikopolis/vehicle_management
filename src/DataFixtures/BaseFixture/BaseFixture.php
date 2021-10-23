<?php

declare(strict_types = 1);

namespace App\DataFixtures\BaseFixture;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Fakecar;
use function count;
use function random_int;
use function sprintf;
use function str_starts_with;

abstract class BaseFixture extends Fixture {
	private ObjectManager $manager;
	private array         $references = [];
	private ?Generator    $faker      = null;
	
	abstract public function loadData(ObjectManager $manager): void;
	
	public function load(ObjectManager $manager): void {
		$this->manager = $manager;
		$this->loadData($manager);
	}
	
	public function faker(): Generator {
		if ($this->faker === null) {
			$this->faker = (new Factory())::create();
		}
		$this->faker->addProvider(new Fakecar($this->faker));
		return $this->faker;
	}
	
	protected function createMany(string $className, int $count, callable $factory): void {
		for ($i = 0; $i < $count; $i++) {
			$entity = new $className();
			$factory($entity, $i);
			$this->manager->persist($entity);
			$this->setReference(sprintf("%s_%d", $className, $i), $entity);
		}
		$this->manager->flush();
	}
	
	protected function getRandomReference(string $className): object {
		if (! array_key_exists($className, $this->references)) {
			$this->references[$className] = [];
			foreach ($this->referenceRepository->getReferences() as $key => $reference) {
				if (str_starts_with($key, sprintf("%s_", $className))) {
					$this->references[$className][] = $key;
				}
			}
		}
		try {
			return $this->getReference($this->references[$className][random_int(0, count($this->references[$className]) - 1)]);
		} catch (Exception $e) {
			throw new $e(sprintf('Cannot find any references for class "%s"', $className));
		}
	}
}