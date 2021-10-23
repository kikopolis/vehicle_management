<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Vehicle;
use App\Entity\VehicleType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class VehicleRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, Vehicle::class);
	}
	
	public function findDemoVehicles(): array {
		return $this->findBy(['isDemo' => true]);
	}
	
	public function findForUserByType(?UserInterface $user, VehicleType $vehicleType): array {
		if (! $user) {
			return $this->findBy(['isDemo' => true, 'type' => $vehicleType]);
		}
		return $this->findBy(['type' => $vehicleType, 'visibleTo' => $user]);
	}
}
