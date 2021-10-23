<?php

declare(strict_types = 1);

namespace App\Tests\TestTraits;

use Faker\Factory;
use Faker\Generator;

trait WithFaker {
	private Generator $faker;
	
	protected function faker(): Generator {
		if (! isset($this->faker)) {
			$this->faker = Factory::create();
		}
		return $this->faker;
	}
}