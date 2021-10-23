<?php

declare(strict_types = 1);

namespace App\Security\Voter;

use App\Entity\Vehicle;
use App\Security\Voter\Contracts\Actions;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class VehicleVoter extends Voter {
	protected function supports(string $attribute, $subject): bool {
		return in_array($attribute, [Actions::VIEW]) && $subject instanceof Vehicle;
	}
	
	/**
	 * @param   string           $attribute
	 * @param   Vehicle          $subject
	 * @param   TokenInterface   $token
	 * @return bool
	 */
	protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool {
		// grant universal access to demo vehicles
		if ($subject->isDemo()) {
			return true;
		}
		$user = $token->getUser();
		if (! $user instanceof UserInterface) {
			return false;
		}
		switch ($attribute) {
			case Actions::VIEW:
				return $subject->getVisibleTo()->contains($user);
		}
		
		return false;
	}
}
