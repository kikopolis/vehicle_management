<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\TaskTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskTypeRepository::class)
 */
final class TaskType {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private ?int $id;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private string $name;
	
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="type")
	 */
	private Collection $tasks;
	
	public function __construct() {
		$this->tasks = new ArrayCollection();
	}
	
	public function getId(): ?int {
		return $this->id;
	}
}
