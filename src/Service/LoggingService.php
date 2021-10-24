<?php

declare(strict_types = 1);

namespace App\Service;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\RequestStack;

final class LoggingService {
	public function __construct(private RequestStack $requestStack, private LoggerInterface $logger) { }
	
	/**
	 * System is unusable.
	 */
	public function emergency(string $message, array $context = []): void {
		$this->log(LogLevel::EMERGENCY, $message, $context);
	}
	
	/**
	 * Action must be taken immediately.
	 * Example: Entire website down, database unavailable, etc.
	 */
	public function alert(string $message, array $context = []): void {
		$this->log(LogLevel::ALERT, $message, $context);
	}
	
	/**
	 * Example: Application component unavailable, unexpected exception.
	 */
	public function critical(string $message, array $context = []): void {
		$this->log(LogLevel::CRITICAL, $message, $context);
	}
	
	/**
	 * Runtime errors that do not require immediate action but should typically
	 * be logged and monitored.
	 */
	public function error(string $message, array $context = []): void {
		$this->log(LogLevel::ERROR, $message, $context);
	}
	
	/**
	 * Example: Use of deprecated APIs, poor use of an API, undesirable things
	 * that are not necessarily wrong.
	 */
	public function warning(string $message, array $context = []): void {
		$this->log(LogLevel::WARNING, $message, $context);
	}
	
	/**
	 * Normal but significant events.
	 */
	public function notice(string $message, array $context = []): void {
		$this->log(LogLevel::NOTICE, $message, $context);
	}
	
	/**
	 * Example: User logs in, SQL logs.
	 */
	public function info(string $message, array $context = []): void {
		$this->log(LogLevel::INFO, $message, $context);
	}
	
	public function debug(string $message, array $context = []): void {
		$this->log(LogLevel::DEBUG, $message, $context);
	}
	
	public function log(string $level, string $message, array $context = []): void {
		$request       = $this->requestStack->getCurrentRequest();
		$context['ip'] = $request?->getClientIp();
		$this->logger->log($level, $message, $context);
	}
}