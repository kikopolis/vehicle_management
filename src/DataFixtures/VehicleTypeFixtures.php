<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\DataFixtures\BaseFixture\BaseFixture;
use App\Entity\Image;
use App\Entity\VehicleType;
use Doctrine\Persistence\ObjectManager;
use function count;
use function mb_strtolower;
use function sprintf;
use function str_replace;

class VehicleTypeFixtures extends BaseFixture {
	private const TYPES = ['Motorbike', 'Car', 'ATV', 'Van', 'Box Truck', 'Semi Truck', 'Trailer', 'Bus', 'Tractor', 'Other'];
	
	public function loadData(ObjectManager $manager): void {
		$this->createMany(VehicleType::class, count(self::TYPES), function (VehicleType $vehicleType, int $i) use ($manager) {
			// create a specific cover image for the type of vehicle
			$image = new Image();
			// set the location considering that an asset will exist for this type in the public folder
			$image->setLocation(sprintf('build/images/vehicletype_covers/%s.jpeg', mb_strtolower(str_replace(' ', '-', self::TYPES[$i]))));
			$manager->persist($image);
			$vehicleType->setName(self::TYPES[$i]);
			$vehicleType->setCoverImg($image);
		});
	}
}