<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\ServiceNoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceNoteRepository::class)
 */
final class ServiceNote extends AbstractNote {
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="notes")
	 */
	private Service $service;
}
