<?php

declare(strict_types = 1);

namespace App\Entity\Concerns;

use App\Entity\Contracts\TimeStampable;
use DateTimeInterface;

trait HasTimestamps {
	protected DateTimeInterface  $createdAt;
	protected ?DateTimeInterface $updatedAt;
	
	public function getCreatedAt(): DateTimeInterface {
		return $this->createdAt;
	}
	
	public function setCreatedAt(DateTimeInterface $createdAt): TimeStampable {
		$this->createdAt = $createdAt;
		return $this;
	}
	
	public function getUpdatedAt(): DateTimeInterface {
		return $this->updatedAt;
	}
	
	public function setUpdatedAt(?DateTimeInterface $updatedAt): TimeStampable {
		$this->updatedAt = $updatedAt;
		return $this;
	}
}