<?php

declare(strict_types = 1);

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase {
	public function testCanCreateUser(): void {
		UserTest::assertTrue(new User() instanceof User);
	}
}
