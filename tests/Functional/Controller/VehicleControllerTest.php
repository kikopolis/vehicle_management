<?php

declare(strict_types = 1);

namespace App\Tests\Functional\Controller;

use App\Entity\User;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use function sprintf;

class VehicleControllerTest extends WebTestCase {
	/**
	 * @dataProvider indexProvider
	 */
	public function testIndex(string $locale, ?User $user): void {
		$client = static::createClient();
		if ($user) {
			$client->loginUser($user);
		}
		$crawler = $client->request('GET', sprintf('/%s/vehicles', $locale));
		static::assertResponseIsSuccessful();
	}
	
	public function indexProvider(): Generator {
		yield 'no user, english locale' => [
			'locale' => 'en',
			'user'   => null,
		];
		
		yield 'no user, estonian locale' => [
			'locale' => 'et',
			'user'   => null,
		];
	}
	
	/**
	 * @dataProvider byTypeProvider
	 */
	public function byTypeTest(string $locale, string $type, ?User $user): void {
		$client = static::createClient();
		if ($user) {
			$client->loginUser($user);
		}
		$crawler = $client->request('GET', sprintf('/%s/vehicles/%s', $locale, $type));
		static::assertResponseIsSuccessful();
	}
	
	public function byTypeProvider(): Generator {
		yield 'no user, english locale' => [
			'locale' => 'en',
			'type'   => 'car',
			'user'   => null,
		];
		
		yield 'no user, estonian locale' => [
			'locale' => 'et',
			'type'   => 'car',
			'user'   => null,
		];
	}
}