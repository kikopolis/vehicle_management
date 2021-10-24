<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\VehicleRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=VehicleRepository::class)
 */
final class Vehicle {
	use TimestampableEntity;
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="bigint")
	 */
	private ?int $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\VehicleType", inversedBy="vehicles")
	 */
	private ?VehicleType $type = null;
	
	/**
	 * @ORM\Column(type="string", length=20)
	 */
	private ?string $vin = null;
	
	/**
	 * @ORM\Column(type="string", length=20)
	 */
	private ?string $registration = null;
	
	/**
	 * @ORM\Column(type="string", length=1000)
	 */
	private ?string $description = null;
	
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	private ?string $make = null;
	
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	private ?string $model = null;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private ?string $trim = null;
	
	/**
	 * @ORM\Column(type="string", length=25)
	 */
	private ?string $transmissionType = null;
	
	/**
	 * @ORM\Column(type="string", length=25)
	 */
	private ?string $fuelType = null;
	
	/**
	 * @ORM\Column(type="string", length=25)
	 */
	private ?string $engineSize = null;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private int $seatCount = 0;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	private bool $isDemo = false;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	private ?DateTimeInterface $manufacturedAt = null;
	
	/**
	 * @ORM\Column(type="date")
	 */
	private ?DateTimeInterface $purchasedAt = null;
	
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
	
	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="visibleVehicles")
	 */
	private Collection $visibleTo;
	
	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Image")
	 */
	private Collection $images;
	
	public function __construct() {
		$this->mileageRecords = new ArrayCollection();
		$this->events         = new ArrayCollection();
		$this->services       = new ArrayCollection();
		$this->tasks          = new ArrayCollection();
		$this->visibleTo      = new ArrayCollection();
		$this->images         = new ArrayCollection();
	}
	
	public function getId(): ?int {
		return $this->id;
	}
	
	public function getType(): ?VehicleType {
		return $this->type;
	}
	
	public function setType(VehicleType $type): Vehicle {
		$this->type = $type;
		return $this;
	}
	
	public function getVin(): ?string {
		return $this->vin;
	}
	
	public function setVin(string $vin): Vehicle {
		$this->vin = $vin;
		return $this;
	}
	
	public function getRegistration(): ?string {
		return $this->registration;
	}
	
	public function setRegistration(string $registration): Vehicle {
		$this->registration = $registration;
		return $this;
	}
	
	public function getDescription(): ?string {
		return $this->description;
	}
	
	public function setDescription(string $description): Vehicle {
		$this->description = $description;
		return $this;
	}
	
	public function getMake(): ?string {
		return $this->make;
	}
	
	public function setMake(string $make): Vehicle {
		$this->make = $make;
		return $this;
	}
	
	public function getModel(): ?string {
		return $this->model;
	}
	
	public function setModel(string $model): Vehicle {
		$this->model = $model;
		return $this;
	}
	
	public function getTrim(): ?string {
		return $this->trim;
	}
	
	public function setTrim(string $trim): Vehicle {
		$this->trim = $trim;
		return $this;
	}
	
	public function getTransmissionType(): ?string {
		return $this->transmissionType;
	}
	
	public function setTransmissionType(string $transmissionType): Vehicle {
		$this->transmissionType = $transmissionType;
		return $this;
	}
	
	public function getFuelType(): ?string {
		return $this->fuelType;
	}
	
	public function setFuelType(string $fuelType): Vehicle {
		$this->fuelType = $fuelType;
		return $this;
	}
	
	public function getEngineSize(): ?string {
		return $this->engineSize;
	}
	
	public function setEngineSize(string $engineSize): Vehicle {
		$this->engineSize = $engineSize;
		return $this;
	}
	
	public function getSeatCount(): int {
		return $this->seatCount;
	}
	
	public function setSeatCount(int $seatCount): Vehicle {
		$this->seatCount = $seatCount;
		return $this;
	}
	
	public function isDemo(): bool {
		return $this->isDemo;
	}
	
	public function setIsDemo(bool $isDemo): Vehicle {
		$this->isDemo = $isDemo;
		return $this;
	}
	
	public function getManufacturedAt(): ?DateTimeInterface {
		return $this->manufacturedAt;
	}
	
	public function setManufacturedAt(?DateTimeInterface $manufacturedAt): Vehicle {
		$this->manufacturedAt = $manufacturedAt;
		return $this;
	}
	
	public function getPurchasedAt(): ?DateTimeInterface {
		return $this->purchasedAt;
	}
	
	public function setPurchasedAt(?DateTimeInterface $purchasedAt): Vehicle {
		$this->purchasedAt = $purchasedAt;
		return $this;
	}
	
	public function getVisibleTo(): Collection {
		return $this->visibleTo;
	}
	
	public function setVisibleTo(Collection $visibleTo): Vehicle {
		$this->visibleTo = $visibleTo;
		return $this;
	}
	
	public function addVisibleTo(User $user): Vehicle {
		if (! $this->visibleTo->contains($user)) {
			$this->visibleTo->add($user);
		}
		return $this;
	}
	
	public function removeVisibleTo(User $user): Vehicle {
		if ($this->visibleTo->contains($user)) {
			$this->visibleTo->removeElement($user);
		}
		return $this;
	}
	
	public function getImages(): ArrayCollection|Collection {
		return $this->images;
	}
	
	public function setImages(ArrayCollection|Collection $images): Vehicle {
		$this->images = $images;
		return $this;
	}
	
	public function addImage(Image $image): Vehicle {
		if (! $this->images->contains($image)) {
			$this->images->add($image);
		}
		return $this;
	}
	
	public function removeImage(Image $image): Vehicle {
		if ($this->images->contains($image)) {
			$this->images->removeElement($image);
		}
		return $this;
	}
}
