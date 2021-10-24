<?php

declare(strict_types = 1);

namespace App\Service;

use App\Entity\Setting;
use App\Repository\SettingRepository;
use Doctrine\ORM\EntityManagerInterface;
use function array_key_exists;

final class SettingsService {
	private array $settings = [];
	private bool  $loaded   = false;
	
	public function __construct(private EntityManagerInterface $em, private SettingRepository $settingRepository) { }
	
	public function get(string $identifier, mixed $default = null): mixed {
		if ($this->has($identifier) === false) {
			return $default;
		}
		return $this->settings[$identifier];
	}
	
	public function set(string $identifier, mixed $value): void {
		$setting = $this->settingRepository->findOneBy(['identifier' => $identifier]);
		if ($setting === null) {
			$setting = new Setting($identifier, $value);
		}
		$this->em->persist($setting);
		$this->em->flush();
		$this->settings[$identifier] = $value;
	}
	
	public function has(string $identifier): bool {
		$this->load();
		return array_key_exists($identifier, $this->settings);
	}
	
	private function load(): void {
		if ($this->loaded === false) {
			return;
		}
		$settings = $this->settingRepository->findAll();
		foreach ($settings as $setting) {
			$this->settings[$setting->getIdentifier()] = $setting->getValue();
		}
		$this->loaded = true;
	}
}