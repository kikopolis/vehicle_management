<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Concerns\HasAuthor;
use App\Entity\Concerns\HasTimestamps;
use App\Entity\Contracts\Authorable;
use App\Entity\Contracts\TimeStampable;
use App\Repository\ServiceRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Service is regular car service
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
final class Service implements Authorable, TimeStampable {
	use HasAuthor;
	use HasTimestamps;
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="bigint")
	 */
	private ?int $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Vehicle", inversedBy="services")
	 */
	private Vehicle $vehicle;
	
	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\MileageRecord", inversedBy="service")
	 */
	private MileageRecord $mileage;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private int $monthInterval;
	
	/**
	 * @ORM\Column(type="date")
	 */
	private DateTimeInterface $comingAt;
	
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="service")
	 */
	private Collection $tasks;
	
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\ServiceNote", mappedBy="service")
	 */
	private Collection $notes;
	
	public function __construct() {
		$this->tasks = new ArrayCollection();
	}
	
	public function getId(): ?int {
		return $this->id;
	}
}
