<?php

declare(strict_types = 1);

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use function is_string;
use function sprintf;

final class MailingService {
	public function __construct(private LoggingService $loggingService, private SettingsService $settingsService, private MailerInterface $mailer) { }
	
	public function send(string $template, array|string $to, string $subject, string $locale, array $context = []): void {
		$toAddress = is_string($to) ? new Address($to) : new Address($to['address'], $to['name']);
		$email     = (new TemplatedEmail())
			->to($toAddress)
			->from(
				new Address(
					$this->settingsService->get('app.from.email', 'no-reply@machinemanagement.com'),
					$this->settingsService->get('app.from.name', 'Administrator Bot')
				)
			)
			->subject($subject)
			->context($context)
			->htmlTemplate(sprintf('emails/%s/%s.html.twig', $locale, $template))
			->textTemplate(sprintf('emails/%s/%s.html.twig', $locale, $template));
		try {
			$this->mailer->send($email);
		} catch (TransportExceptionInterface $e) {
			$this->loggingService->warning(sprintf('Cannot send email : %s', $e->getMessage()), [
				'exception' => $e,
				'template'  => $template,
				'to'        => $to,
				'subject'   => $subject,
				'context'   => $context,
			]);
		}
	}
	
	public function sendToUser(User $user, string $template, string $subject, string $locale, array $context = []): void {
		$this->send($template, ['address' => $user->getEmail(), 'name' => $user->getName()], $subject, $locale, $context);
	}
}