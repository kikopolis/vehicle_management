<?php

declare(strict_types = 1);

namespace App\DataFixtures\BaseFixture;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;
use Faker\Generator;
use function count;
use function random_int;
use function sprintf;
use function str_starts_with;

abstract class BaseFixture extends Fixture {
	private ObjectManager $manager;
	private array         $referencesIndex = [];
	private ?Generator    $faker           = null;
	
	abstract public function loadData(ObjectManager $manager): void;
	
	public function load(ObjectManager $manager): void {
		$this->manager = $manager;
		$this->loadData($manager);
	}
	
	public function faker(): Generator {
		if ($this->faker === null) {
			$this->faker = (new Factory())::create();
		}
		return $this->faker;
	}
	
	protected function createMany(string $className, int $count, callable $factory): void {
		for ($i = 0; $i < $count; $i++) {
			$entity = new $className();
			$factory($entity, $i);
			$this->manager->persist($entity);
			$this->setReference(sprintf("%s_%d", $className, $i), $entity);
		}
	}
	
	protected function getRandomReference(string $className): object {
		if (! array_key_exists($className, $this->referencesIndex)) {
			$this->referencesIndex[$className] = [];
			foreach ($this->referencesIndex as $key => $reference) {
				if (str_starts_with($key, sprintf("%s_", $className))) {
					$this->referencesIndex[$className][] = $reference;
				}
			}
		}
		if (! isset($this->referencesIndex[$className])) {
			throw new Exception(sprintf('Cannot find any references for class "%s"', $className));
		}
		return $this->getReference($this->referencesIndex[$className][random_int(0, count($this->referencesIndex[$className]) - 1)]);
	}
}