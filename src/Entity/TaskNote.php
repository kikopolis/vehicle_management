<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\TaskNoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskNoteRepository::class)
 */
final class TaskNote extends AbstractNote {
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Task", inversedBy="notes")
	 */
	private Task $task;
}
