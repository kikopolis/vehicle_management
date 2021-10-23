<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\DataFixtures\BaseFixture\BaseFixture;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends BaseFixture {
	public function __construct(private UserPasswordHasherInterface $hasher) { }
	
	public function loadData(ObjectManager $manager): void {
		$this->createMany(User::class, 10, function (User $user) {
			$user->setName($this->faker()->name);
			$user->setEmail($this->faker()->email);
			$user->setPassword($this->hasher->hashPassword($user, 'secret'));
			$user->setCreatedAt($this->faker()->dateTime);
		});
	}
}
