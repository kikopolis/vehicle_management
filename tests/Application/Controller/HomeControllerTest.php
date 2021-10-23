<?php

declare(strict_types = 1);

namespace App\Tests\Application\Controller;

use Generator;
use Symfony\Component\Panther\PantherTestCase;
use function sprintf;

class HomeControllerTest extends PantherTestCase {
	/**
	 * @dataProvider homeProvider
	 */
	public function testHome(string $locale, ?string $expected): void {
		static::createPantherClient()->request('GET', sprintf("/%s", $locale));
		if ($expected) {
			static::assertSelectorTextContains('h1', $expected);
		} else {
			static::assertSelectorExists('h1');
		}
	}
	
	public function homeProvider(): Generator {
		yield 'home with default locale' => [
			'locale'   => '',
			'expected' => null,
		];
		yield 'home with english locale' => [
			'locale'   => 'en',
			'expected' => 'Welcome',
		];
		yield 'home with estonian locale' => [
			'locale'   => 'et',
			'expected' => 'Tere Tulemast',
		];
	}
	
	/**
	 * @dataProvider termsProvider
	 */
	public function testTerms(string $locale, ?string $expected) {
		static::createPantherClient()->request('GET', sprintf("/%s/terms-and-conditions", $locale));
		static::assertSelectorTextContains('h1', $expected);
	}
	
	public function termsProvider(): Generator {
		yield 'terms with english locale' => [
			'locale'   => 'en',
			'expected' => 'Terms and Conditions',
		];
		yield 'terms with estonian locale' => [
			'locale'   => 'et',
			'expected' => 'Terminid ja Kasutajatingimused',
		];
	}
}
