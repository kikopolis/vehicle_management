<?php

declare(strict_types = 1);

namespace App\Entity\Concerns;

use App\Entity\Contracts\Authorable;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

trait HasAuthor {
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 */
	private User $author;
	
	public function getAuthor(): User {
		return $this->author;
	}
	
	public function setAuthor(User $author): Authorable {
		$this->author = $author;
		return $this;
	}
}
