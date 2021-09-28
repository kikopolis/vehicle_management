<?php

declare(strict_types = 1);

namespace App\Entity\Concerns;

use HTMLPurifier;
use HTMLPurifier_Config;

trait CanPurify {
	private ?HTMLPurifier $purifier = null;
	
	public function purify(string $dirty): string {
		if ($this->purifier === null) {
			$config = HTMLPurifier_Config::createDefault();
			$config->set('Core', 'Encoding', 'utf-8');
			$config->set('HTML', 'Doctype', 'html');
			$this->purifier = new HTMLPurifier($config);
		}
		return $this->purifier->purify($dirty);
	}
}