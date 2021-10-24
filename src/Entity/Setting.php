<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\SettingRepository;
use Doctrine\ORM\Mapping as ORM;
use function serialize;
use function unserialize;

/**
 * @ORM\Entity(repositoryClass=SettingRepository::class)
 */
class Setting {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private ?int $id;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=false)
	 */
	private ?string $identifier = null;
	
	/**
	 * @ORM\Column(type="string", length=2024, nullable=false)
	 */
	private ?string $value = null;
	
	public function __construct(string $identifier, mixed $value) {
		$this->identifier = $identifier;
		$this->setValue($value);
	}
	
	public function getId(): ?int {
		return $this->id;
	}
	
	public function getIdentifier(): string {
		return $this->identifier;
	}
	
	public function setIdentifier(string $identifier): Setting {
		$this->identifier = $identifier;
		return $this;
	}
	
	public function getValue(): mixed {
		return unserialize($this->value);
	}
	
	public function setValue(mixed $value): Setting {
		$this->value = serialize($value);
		return $this;
	}
}
