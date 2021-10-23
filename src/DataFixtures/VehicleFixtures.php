<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\DataFixtures\BaseFixture\BaseFixture;
use App\Entity\Vehicle;
use App\Entity\VehicleType;
use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use function mt_rand;

class VehicleFixtures extends BaseFixture implements DependentFixtureInterface {
	public function loadData(ObjectManager $manager): void {
		$this->createMany(Vehicle::class, 45, function (Vehicle $vehicle) {
			$vehicle->setDescription($this->faker()->paragraph);
			$vehicle->setType($this->getRandomReference(VehicleType::class));
			$vehicle->setMake($this->faker()->vehicleBrand);
			$vehicle->setModel($this->faker()->vehicleModel);
			$vehicle->setTrim($this->faker()->word);
			$vehicle->setFuelType($this->faker()->vehicleFuelType);
			$vehicle->setEngineSize((string) mt_rand(1, 16));
			$vehicle->setSeatCount($this->faker()->vehicleSeatCount);
			$vehicle->setTransmissionType($this->faker()->vehicleGearBoxType);
			$vehicle->setRegistration($this->faker()->vehicleRegistration('[0-9]{3} [A-Z]{3}'));
			$vehicle->setVin($this->faker()->vin);
			$vehicle->setFuelType($this->faker()->vehicleFuelType);
			$vehicle->setManufacturedAt($this->faker()->dateTimeBetween('-15 years', '-3 years'));
			$vehicle->setCreatedAt($this->faker()->dateTimeBetween('-2 years', '-1 month'));
			$vehicle->setPurchasedAt($this->faker()->dateTimeBetween($vehicle->getManufacturedAt(), $vehicle->getCreatedAt()));
		});
		
		$this->createMany(Vehicle::class, 20, function (Vehicle $vehicle) {
			$vehicle->setDescription($this->faker()->paragraph);
			$vehicle->setType($this->getRandomReference(VehicleType::class));
			$vehicle->setMake($this->faker()->vehicleBrand);
			$vehicle->setModel($this->faker()->vehicleModel);
			$vehicle->setTrim($this->faker()->word);
			$vehicle->setFuelType($this->faker()->vehicleFuelType);
			$vehicle->setEngineSize((string) mt_rand(1, 16));
			$vehicle->setSeatCount($this->faker()->vehicleSeatCount);
			$vehicle->setTransmissionType($this->faker()->vehicleGearBoxType);
			$vehicle->setRegistration($this->faker()->vehicleRegistration('[0-9]{3} [A-Z]{3}'));
			$vehicle->setVin($this->faker()->vin);
			$vehicle->setFuelType($this->faker()->vehicleFuelType);
			$vehicle->setManufacturedAt($this->faker()->dateTimeBetween('-15 years', '-3 years'));
			$vehicle->setCreatedAt($this->faker()->dateTimeBetween('-2 years', '-1 month'));
			$vehicle->setPurchasedAt($this->faker()->dateTimeBetween($vehicle->getManufacturedAt(), $vehicle->getCreatedAt()));
			// set some demos
			$vehicle->setIsDemo(true);
		});
	}
	
	public function getDependencies(): array {
		return [VehicleTypeFixtures::class];
	}
}