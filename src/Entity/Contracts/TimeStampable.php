<?php

declare(strict_types = 1);

namespace App\Entity\Contracts;

use DateTimeInterface;

interface TimeStampable {
	public function getCreatedAt(): DateTimeInterface;
	
	public function setCreatedAt(DateTimeInterface $createdAt): TimeStampable;
	
	public function getUpdatedAt(): ?DateTimeInterface;
	
	public function setUpdatedAt(?DateTimeInterface $updatedAt): TimeStampable;
}