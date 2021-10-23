<?php

declare(strict_types = 1);

namespace App\Entity\Concerns;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait HasAuthor {
	/**
	 * @Gedmo\Blameable(on="create")
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
	 */
	protected User $author;
	
	public function getAuthor(): User {
		return $this->author;
	}
	
	public function setAuthor(User $author): self {
		$this->author = $author;
		return $this;
	}
}
