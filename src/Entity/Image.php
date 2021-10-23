<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use function array_push;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="bigint")
	 */
	private ?int $id;
	
	/**
	 * @ORM\Column(type="string", length=1024, nullable=false)
	 */
	private ?string $location;
	
	/**
	 * @ORM\Column(type="json", nullable=true)
	 */
	private array $tags;
	
	public function __construct() { }
	
	public function getId(): ?int {
		return $this->id;
	}
	
	public function getLocation(): ?string {
		return $this->location;
	}
	
	public function setLocation(string $location): Image {
		$this->location = $location;
		return $this;
	}
	
	public function getTags(): array {
		return $this->tags;
	}
	
	public function setTags(array $tags): Image {
		$this->tags = $tags;
		return $this;
	}
}
