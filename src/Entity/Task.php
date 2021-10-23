<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Concerns\HasAuthor;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\Blameable;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Task is oil change
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
final class Task {
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
