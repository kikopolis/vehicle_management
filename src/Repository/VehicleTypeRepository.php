<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Entity\VehicleType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VehicleType|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehicleType|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehicleType[]    findAll()
 * @method VehicleType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleTypeRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, VehicleType::class);
	}
	
	public function findPublic(): array {
		return $this->findAll();
	}
}
