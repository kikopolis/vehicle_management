<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Concerns\HasAuthor;
use App\Entity\Concerns\HasTimestamps;
use App\Entity\Contracts\Authorable;
use App\Entity\Contracts\TimeStampable;
use App\Repository\MileageRecordRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MileageRecordRepository::class)
 */
final class MileageRecord implements TimeStampable, Authorable {
	use HasTimestamps;
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
