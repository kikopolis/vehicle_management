<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Entity\EventNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventNote|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventNote|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventNote[]    findAll()
 * @method EventNote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class EventNoteRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, EventNote::class);
	}
}
