<?php

declare(strict_types = 1);

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LocaleSubscriber implements EventSubscriberInterface {
	public function __construct(private SessionInterface $session) { }
	
	public static function getSubscribedEvents(): array {
		return [LoginSuccessEvent::class => ['onLogin', 10]];
	}
	
	public function onLogin(LoginSuccessEvent $event): void {
		$user = $event->getUser();
		if (! $user instanceof User) {
			$this->session->set('_locale', 'en');
			return;
		}
		$this->session->set('_locale', $user->getLocale());
	}
}
