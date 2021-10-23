<?php

declare(strict_types = 1);

namespace App\Twig;

use App\Twig\Filter\TruncateFilter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension {
	public function getFilters(): array {
		return [
			new TwigFilter('truncate', [TruncateFilter::class, 'truncate']),
		];
	}
}