<?php

declare(strict_types = 1);

namespace App\Tests\Application\Controller;

use Symfony\Component\Panther\PantherTestCase;

class HomeControllerTest extends PantherTestCase {
	public function testSomething(): void {
		$client  = static::createPantherClient();
		$crawler = $client->request('GET', '/');
		
		static::assertSelectorTextContains('h1', 'Hello World');
	}
}
