<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\VehicleTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=VehicleTypeRepository::class)
 */
class VehicleType {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="bigint")
	 */
	private ?int $id;
	
	/**
	 * @ORM\Column(type="string", length=25)
	 */
	private ?string $name = null;
	
	/**
	 * @ORM\Column(type="string", length=25)
	 * @Gedmo\Slug(fields={"name"}, unique=true)
	 */
	private string $slug;
	
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Vehicle", mappedBy="type")
	 */
	private Collection $vehicles;
	
	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\Image")
	 */
	private ?Image $coverImg = null;
	
	public function __construct() {
		$this->vehicles = new ArrayCollection();
	}
	
	public function getId(): ?int {
		return $this->id;
	}
	
	public function getName(): ?string {
		return $this->name;
	}
	
	public function setName(string $name): VehicleType {
		$this->name = $name;
		return $this;
	}
	
	public function getSlug(): string {
		return $this->slug;
	}
	
	public function getVehicles(): Collection {
		return $this->vehicles;
	}
	
	public function getCoverImg(): ?Image {
		return $this->coverImg;
	}
	
	public function setCoverImg(?Image $coverImg): VehicleType {
		$this->coverImg = $coverImg;
		return $this;
	}
}
