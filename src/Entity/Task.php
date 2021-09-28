<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Concerns\HasAuthor;
use App\Entity\Concerns\HasTimestamps;
use App\Entity\Contracts\Authorable;
use App\Entity\Contracts\TimeStampable;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Task is oil change
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
final class Task implements Authorable, TimeStampable {
	use HasAuthor;
	use HasTimestamps;
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="bigint")
	 */
	private ?int $id;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	private bool $status;
	
	/**
	 * @ORM\Column(type="text", length=4000)
	 */
	private string $description;
	
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\TaskType", inversedBy="tasks")
	 */
	private TaskType $type;
	
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="tasks")
	 */
	private ?Service $service;
	
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Vehicle", inversedBy="tasks")
	 */
	private Vehicle $vehicle;
	
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\TaskNote", mappedBy="task")
	 */
	private Collection $notes;
	
	public function __construct() {
		$this->notes = new ArrayCollection();
	}
	
	public function getId(): ?int {
		return $this->id;
	}
}
