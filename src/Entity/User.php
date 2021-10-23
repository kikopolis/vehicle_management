<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use function array_diff;
use function array_unique;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields="email", message="user.register.email.in.use", groups={"register"})
 */
final class User implements UserInterface, PasswordAuthenticatedUserInterface {
	use TimestampableEntity;
	
	public const ROLE_USER  = 'ROLE_USER';
	public const ROLE_ADMIN = 'ROLE_ADMIN';
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="bigint")
	 */
	private ?int $id;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank(
	 *     message="user.register.name.not.blank",
	 *     groups={"register"}
	 *     )
	 * @Assert\Regex(
	 *     pattern="/^[a-zA-Z\ \_\-\.\']+$/",
	 *     message="user.register.name.characters",
	 *     groups={"register"}
	 * )
	 * @Assert\Length(
	 *     max=255,
	 *     maxMessage="user.register.name.length.max",
	 *     min=4,
	 *     minMessage="user.register.name.length.min",
	 *     groups={"register"}
	 * )
	 */
	private string $name;
	
	/**
	 * @Assert\NotBlank(
	 *     message="user.register.email.not.blank",
	 *     groups={"register"}
	 *     )
	 * @Assert\Email(
	 *     message="user.register.email.regex",
	 *     groups={"register"}
	 *     )
	 * @ORM\Column(type="string", length=180, unique=true)
	 */
	private string $email;
	
	/**
	 * @ORM\Column(type="json")
	 */
	private array $roles = [self::ROLE_USER];
	
	/**
	 * @ORM\Column(type="string")
	 */
	private string $password;
	
	/**
	 * @Assert\NotBlank(
	 *     message="user.register.password.not.blank",
	 *     groups={"register"}
	 *     )
	 * @Assert\Length(
	 *     min="12",
	 *     minMessage="user.register.password.length.min",
	 *     max="8096",
	 *     maxMessage="user.register.password.length.max"
	 *     )
	 * @Assert\Regex(
	 *     pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{12,}$/",
	 *     message="user.register.password.regex",
	 *     groups={"register"}
	 *     )
	 */
	private string $plainPassword;
	
	/**
	 * @Assert\NotBlank(
	 *     message="user.register.password.repeat.not.blank",
	 *     groups={"register"}
	 *     )
	 * @Assert\Expression(
	 *     expression="this.getPlainPassword() === this.getRepeatPlainPassword()",
	 *     message="user.register.password.repeat.mismatch",
	 *     groups={"register"}
	 *     )
	 */
	private string $repeatPlainPassword;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	private bool $activated = false;
	
	/**
	 * @ORM\Column(type="string", length=3)
	 * @Assert\Length(
	 *     max="2",
	 *     maxMessage="user.locale.length.max",
	 *     groups={"register"}
	 * )
	 */
	private string $locale = 'en';
	
	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Vehicle", mappedBy="visibleTo")
	 */
	private Collection $visibleVehicles;
	
	public function __construct() {
		$this->visibleVehicles = new ArrayCollection();
	}
	
	public function getId(): ?int {
		return $this->id;
	}
	
	public function getName(): string {
		return $this->name;
	}
	
	public function setName(string $name): User {
		$this->name = $name;
		return $this;
	}
	
	public function getEmail(): ?string {
		return $this->email;
	}
	
	public function setEmail(string $email): self {
		$this->email = $email;
		return $this;
	}
	
	public function getUserIdentifier(): string {
		return $this->email;
	}
	
	public function getUsername(): string {
		return $this->email;
	}
	
	public function getRoles(): array {
		return array_unique($this->roles);
	}
	
	public function hasRole(string $role): bool {
		if (in_array($role, $this->roles)) {
			return true;
		}
		return false;
	}
	
	public function setRoles(array $roles): self {
		$this->roles = array_unique($roles);
		return $this;
	}
	
	public function addRole(string $role): self {
		$this->roles = array_unique([...$this->roles, $role]);
		return $this;
	}
	
	public function removeRole(string $role): self {
		$this->roles = array_diff($this->roles, [$role]);
		return $this;
	}
	
	public function getPassword(): string {
		return $this->password;
	}
	
	public function setPassword(string $password): self {
		$this->password = $password;
		return $this;
	}
	
	public function getPlainPassword(): string {
		return $this->plainPassword;
	}
	
	public function setPlainPassword(string $plainPassword): User {
		$this->plainPassword = $plainPassword;
		return $this;
	}
	
	public function getRepeatPlainPassword(): string {
		return $this->repeatPlainPassword;
	}
	
	public function setRepeatPlainPassword(string $repeatPlainPassword): User {
		$this->repeatPlainPassword = $repeatPlainPassword;
		return $this;
	}
	
	public function isActivated(): bool {
		return $this->activated;
	}
	
	public function setActivated(bool $activated): User {
		$this->activated = $activated;
		return $this;
	}
	
	public function getSalt(): ?string {
		return null;
	}
	
	public function eraseCredentials(): void {
		$this->plainPassword       = '';
		$this->repeatPlainPassword = '';
	}
	
	public function getLocale(): string {
		return $this->locale;
	}
	
	public function setLocale(string $locale): User {
		$this->locale = $locale;
		return $this;
	}
	
	public function getVisibleVehicles(): ArrayCollection|Collection {
		return $this->visibleVehicles;
	}
	
	public function setVisibleVehicles(ArrayCollection|Collection $visibleVehicles): User {
		$this->visibleVehicles = $visibleVehicles;
		return $this;
	}
	
	public function addVisibleVehicle(Vehicle $vehicle): User {
		if (! $this->visibleVehicles->contains($vehicle)) {
			$this->visibleVehicles->add($vehicle);
			$vehicle->addVisibleTo($this);
		}
		return $this;
	}
	
	public function removeVisibleVehicle(Vehicle $vehicle): User {
		if ($this->visibleVehicles->contains($vehicle)) {
			$this->visibleVehicles->removeElement($vehicle);
			$vehicle->removeVisibleTo($this);
		}
		return $this;
	}
}
