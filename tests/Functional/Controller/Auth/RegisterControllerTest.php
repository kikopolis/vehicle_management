<?php

declare(strict_types = 1);

namespace App\Tests\Functional\Controller\Auth;

use App\Tests\TestTraits\WithFaker;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use function sprintf;

class RegisterControllerTest extends WebTestCase {
	use WithFaker;
	
	/**
	 * @dataProvider registerProvider
	 */
	public function testRegisterPage(string $locale, string $title): void {
		$client = static::createClient();
		$client->request('GET', sprintf('/%s/register', $locale));
		static::assertSelectorExists('h1');
		static::assertStringContainsStringIgnoringCase($title, $client->getResponse()->getContent());
	}
	
	public function registerProvider(): Generator {
		yield 'registration page for english' => [
			'locale' => 'en',
			'title'  => 'REGISTER A NEW ACCOUNT',
		];
		yield 'registration page for estonian' => [
			'locale' => 'et',
			'title'  => 'REGISTREERI UUS KONTO',
		];
	}
	
	/**
	 * @dataProvider registerFormProvider
	 */
	public function testRegisterForm(string $locale, string $button, array $user, string $message): void {
		$client                                = static::createClient();
		$crawler                               = $client->request('GET', sprintf('/%s/register', $locale));
		$form                                  = $crawler->selectButton($button)->form();
		$form['register[name]']                = $user['name'];
		$form['register[email]']               = $user['email'];
		$form['register[plainPassword]']       = $user['plainPassword'];
		$form['register[repeatPlainPassword]'] = $user['repeatPlainPassword'];
		$form['register[locale]']              = $user['locale'];
		$form['register[agreeToTerms]']        = $user['agreeToTerms'];
		$client->submit($form);
		static::assertStringContainsStringIgnoringCase($message, $client->getResponse()->getContent());
	}
	
	public function registerFormProvider(): Generator {
		yield 'registration data for english' => [
			'locale'  => 'en',
			'button'  => 'Register',
			'user'    => [
				'name'                => $this->faker()->name,
				'email'               => $this->faker()->email,
				'plainPassword'       => 'plainPassword123',
				'repeatPlainPassword' => 'plainPassword123',
				'locale'              => 'en',
				'agreeToTerms'        => '1',
			],
			'message' => 'thank you for registering',
		];
		yield 'registration data for estonian' => [
			'locale'  => 'et',
			'button'  => 'Registreeri',
			'user'    => [
				'name'                => $this->faker()->name,
				'email'               => $this->faker()->email,
				'plainPassword'       => 'plainPassword123',
				'repeatPlainPassword' => 'plainPassword123',
				'locale'              => 'en',
				'agreeToTerms'        => '1',
			],
			'message' => 'aitäh registreerimast!',
		];
	}
}
