<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Concerns\HasAuthor;
use App\Entity\Concerns\HasTimestamps;
use App\Entity\Contracts\Authorable;
use App\Entity\Contracts\TimeStampable;
use App\Repository\EventRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event is inspection date
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
final class Event implements Authorable, TimeStampable {
	use HasAuthor;
	use HasTimestamps;
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private ?int $id;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private int $monthInterval;
	
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Vehicle", inversedBy="events")
	 */
	private Vehicle $vehicle;
	
	/**
	 * @ORM\Column(type="date")
	 */
	private DateTimeInterface $comingAt;
	
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\EventNote", mappedBy="event")
	 */
	private Collection $notes;
	
	public function __construct() {
		$this->notes = new ArrayCollection();
	}
	
	public function getId(): ?int {
		return $this->id;
	}
}
