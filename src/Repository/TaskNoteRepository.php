<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Entity\TaskNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskNote|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskNote|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskNote[]    findAll()
 * @method TaskNote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class TaskNoteRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, TaskNote::class);
	}
}
