<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 29/12/2024, 21:54
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    EquatableTrait.php
 * @date    01/12/2024
 * @time    18:58
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Traits\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Symfony\Component\Security\Core\User\UserInterface;
use function count;

/**
 * https://symfony.com/doc/5.4/security.html#comparing-users-manually-with-equatableinterface.
 */
trait EquatableTrait
{
	#[ORM\Column(type: Types::STRING, length: 45)]
	protected string $sessionId = '';

	public function getSessionId (): string
	{
		return $this->sessionId;
	}

	public function setSessionId (string $sessionId): static
	{
		$this->sessionId = $sessionId;

		return $this;
	}

	/** @param AbstractUser $user */
	public function isEqualTo (UserInterface $user): bool
	{
		if (!$user instanceof self
		    || $this->getsessionId() !== $user->getsessionId() // Only 1 session active
		    || $this->getPassword() !== $user->getPassword()
		    || $this->getUserIdentifier() !== $user->getUserIdentifier()
		    || $this->isInactive() !== $user->isInactive()
		) {
			return false;
		}

		$currentRoles = array_map('strval', $this->getRoles());
		$newRoles = array_map('strval', $user->getRoles());
		$rolesChanged = count($currentRoles) !== count($newRoles)
		                || count($currentRoles) !== count(array_intersect($currentRoles, $newRoles));
		if ($rolesChanged) {
			return false;
		}

		return true;
	}
}
