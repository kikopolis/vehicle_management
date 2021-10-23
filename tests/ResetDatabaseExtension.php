<?php

declare(strict_types = 1);

namespace App\Tests;

use App\Kernel;
use PHPUnit\Runner\BeforeFirstTestHook;
use PHPUnit\Runner\BeforeTestHook;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use function copy;
use function dirname;
use function fclose;
use function file_exists;
use function filemtime;
use function fopen;
use function mkdir;
use function str_replace;
use function time;

class ResetDatabaseExtension implements BeforeFirstTestHook, BeforeTestHook {
	private static string $actual = '';
	private static string $backUp = '';
	private static string $dbname = 'test';
	
	public function executeBeforeFirstTest(): void {
		$this->reset();
	}
	
	public function executeBeforeTest(string $test): void {
		$this->loadBackup(false);
	}
	
	public function reset(bool $reset = false): void {
		$this->init();
		$this->loadBackup($reset);
	}
	
	private function init(): void {
		self::$actual = sprintf("%s/var/db/%s.db", dirname(__DIR__), static::$dbname);
		self::$backUp = sprintf("%s/var/db/%s-backup.db", dirname(__DIR__), static::$dbname);
		$this->mkActual();
	}
	
	private function loadBackup(bool $reset): void {
		if ($reset || ! file_exists(self::$backUp) || filemtime(self::$actual) < time() - 600) {
			self::createBackup();
		}
		copy(self::$backUp, self::$actual);
	}
	
	private function createBackup(): void {
		self::resetDb();
		copy(self::$actual, self::$backUp);
	}
	
	private function resetDb(): void {
		$kernel = new Kernel('test', true);
		$kernel->boot();
		$app = new Application($kernel);
		$cmd = $app->find('app:doctrine:fresh');
		$app->setAutoExit(false);
		$input  = new ArrayInput(['command' => 'app:doctrine:fresh']);
		$output = new ConsoleOutput();
		$app->add($cmd);
		$cmd->run($input, $output);
	}
	
	private function mkActual(): void {
		$dir = str_replace(sprintf("%s.db", static::$dbname), '', static::$actual);
		if (! file_exists($dir)) {
			mkdir($dir, recursive: true);
		}
	}
}