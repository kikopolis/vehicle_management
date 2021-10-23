<?php

declare(strict_types = 1);

namespace App\Twig\Filter;

use Twig\Extension\RuntimeExtensionInterface;
use function mb_strcut;

class TruncateFilter implements RuntimeExtensionInterface {
	public function truncate(string $text): string {
		return sprintf("%s...", mb_strcut($text, 0, 146));
	}
}