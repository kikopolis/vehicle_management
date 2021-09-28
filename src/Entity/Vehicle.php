<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Concerns\HasTimestamps;
use App\Entity\Contracts\TimeStampable;
use App\Repository\VehicleRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VehicleRepository::class)
 */
final class Vehicle implements TimeStampable {
	use HasTimestamps;
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="bigint")
	 */
	private ?int $id;
	
	private string $vin;
	
	private string $registration;
	
	private string $description;
	
	private DateTimeInterface $year;
	
	private string $make;
	
	private string $model;
	
	private string $trim;
	
	private string $transmissionType;
	
	private string $fuelType;
	
	private string $engineSize;
	
	private int $seatCount;
	
	private DateTimeInterface $purchasedAt;
	
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="vehicle")
	 */
	private Collection $events;
	
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\MileageRecord", mappedBy="vehicle")
	 */
	private Collection $mileageRecords;
	
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="vehicle")
	 */
	private Collection $services;
	
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="vehicle")
	 */
	private Collection $tasks;
	
	public function __construct() {
		$this->mileageRecords = new ArrayCollection();
		$this->events         = new ArrayCollection();
		$this->services       = new ArrayCollection();
		$this->tasks          = new ArrayCollection();
	}
	
	public function getId(): ?int {
		return $this->id;
	}
}
