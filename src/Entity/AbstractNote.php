<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Concerns\CanPurify;
use App\Entity\Concerns\HasAuthor;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\Blameable;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\MappedSuperclass()
 * @ORM\DiscriminatorMap({
 *     "event_note" = "App\Entity\EventNote",
 *     "service_note" = "App\Entity\ServiceNote",
 *     "task_note" = "App\Entity\TaskNote",
 * })
 */
abstract class AbstractNote {
	use CanPurify;
	use TimestampableEntity;
	use Blameable;
	use HasAuthor;
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="bigint")
	 */
	private ?int $id;
	
	/**
	 * @ORM\Column(type="text", length=4000)
	 */
	private string $text;
	
	public function getId(): ?int {
		return $this->id;
	}
	
	public function getText(): string {
		return $this->text;
	}
	
	public function setText(string $text): AbstractNote {
		$this->text = $text;
		return $this;
	}
}
