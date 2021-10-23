<?php

declare(strict_types = 1);

namespace App\Tests\Functional\Controller\Auth;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\TestTraits\WithFaker;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use function sprintf;

class LoginControllerTest extends WebTestCase {
	use WithFaker;
	
	/**
	 * @dataProvider loginProvider
	 */
	public function testLogin(string $locale, string $button, string $message): void {
		$client    = self::createClient();
		$em        = self::getContainer()->get(EntityManagerInterface::class);
		$pwdHasher = self::getContainer()->get(UserPasswordHasherInterface::class);
		$email     = $this->faker()->email;
		$pwd       = 'Password123456';
		$user      = new User();
		$user->setName($this->faker()->name);
		$user->setEmail($email);
		$user->setPassword($pwdHasher->hashPassword($user, $pwd));
		$user->setLocale($locale);
		$user->setActivated(true);
		$user->setCreatedAt(new DateTime('now'));
		$em->persist($user);
		$em->flush();
		$crawler          = $client->request('GET', sprintf('/%s/login', $locale));
		$form             = $crawler->selectButton($button)->form();
		$form['email']    = $email;
		$form['password'] = $pwd;
		$client->submit($form);
		static::assertResponseRedirects();
		$client->followRedirect();
		static::assertStringContainsStringIgnoringCase($message, $client->getResponse()->getContent());
	}
	
	public function loginProvider(): Generator {
		yield 'user can login with english' => [
			'locale'  => 'en',
			'button'  => 'Sign In',
			'message' => 'Welcome',
		];
		
		yield 'user can login with estonian' => [
			'locale'  => 'et',
			'button'  => 'Logi Sisse',
			'message' => 'Tere Tulemast',
		];
	}
}
