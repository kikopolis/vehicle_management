<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Entity\TaskType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskType|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskType|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskType[]    findAll()
 * @method TaskType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class TaskTypeRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, TaskType::class);
	}
}
