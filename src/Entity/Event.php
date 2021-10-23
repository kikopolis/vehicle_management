<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Concerns\HasAuthor;
use App\Entity\Contracts\Authorable;
use App\Repository\EventRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Event is inspection date
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
final class Event {
	use BlameableEntity;
	use TimestampableEntity;
	use HasAuthor;
	
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
