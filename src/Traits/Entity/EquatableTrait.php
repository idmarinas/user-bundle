<?php
/**
 * Copyright 2024-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/10/2026, 19:34
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
 * @since   1.0.0
 */

namespace Idm\Bundle\User\Traits\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Symfony\Component\Security\Core\User\UserInterface;
use function count;

/**
 * Implements UserInterface::isEqualTo() to compare users manually as described in
 * https://symfony.com/doc/current/security.html#comparing-users-manually-with-equatableinterface.
 *
 * Two users are only considered equal when every security relevant attribute matches:
 * password, user identifier, inactive flag and roles. Comparing the session id as well
 * limits each user to a single active session per device and firewall, so logging in
 * again from somewhere else invalidates the previous session.
 */
trait EquatableTrait
{
	#[ORM\Column(type: Types::STRING, length: 45)]
	protected string $sessionId = '';

	public function getSessionId(): string
	{
		return $this->sessionId;
	}

	public function setSessionId(string $sessionId): static
	{
		$this->sessionId = $sessionId;

		return $this;
	}

	/** @param AbstractUser $user */
	public function isEqualTo(UserInterface $user): bool
	{
		if (!$user instanceof self
			|| $this->getsessionId() !== $user->getsessionId() // Only 1 session active
			|| $this->getPassword() !== $user->getPassword()
			|| $this->getUserIdentifier() !== $user->getUserIdentifier()
			|| $this->isInactive() !== $user->isInactive()
		) {
			return false;
		}

		$currentRoles = array_map(strval(...), $this->getRoles());
		$newRoles = array_map(strval(...), $user->getRoles());
		$rolesChanged = count($currentRoles) !== count($newRoles)
			|| count($currentRoles) !== count(array_intersect($currentRoles, $newRoles));

		return !$rolesChanged;
	}
}
