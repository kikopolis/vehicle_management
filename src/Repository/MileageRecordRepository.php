<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Entity\MileageRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MileageRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method MileageRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method MileageRecord[]    findAll()
 * @method MileageRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class MileageRecordRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, MileageRecord::class);
	}
}
