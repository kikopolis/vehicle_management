<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\EventNoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventNoteRepository::class)
 */
final class EventNote extends AbstractNote {
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="notes")
	 */
	private Event $event;
}
