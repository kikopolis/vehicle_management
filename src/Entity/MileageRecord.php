<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Concerns\HasAuthor;
use App\Repository\MileageRecordRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\Blameable;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=MileageRecordRepository::class)
 */
final class MileageRecord {
	use Blameable;
	use TimestampableEntity;
	use HasAuthor;
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="bigint")
	 */
	private ?int $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Vehicle", inversedBy="mileageRecords")
	 */
	private Vehicle $vehicle;
	
	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\Service", mappedBy="mileage")
	 */
	private ?Service $service;
	
	public function getId(): ?int {
		return $this->id;
	}
}
