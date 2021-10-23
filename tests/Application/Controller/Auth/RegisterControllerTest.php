<?php

declare(strict_types = 1);

namespace App\Tests\Application\Controller\Auth;

use Symfony\Component\Panther\PantherTestCase;

class RegisterControllerTest extends PantherTestCase {
	public function testRegisterPageAndFormTogether() {
		$client  = static::createPantherClient();
		$crawler = $client->request('GET', '/en/register');
		static::assertSelectorExists('h1');
	}
}
