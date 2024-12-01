<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 1/12/24, 18:57
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
 * @since   1.1.0
 */

/**
 * This file is part of Bundle "IdmUserBundle".
 *
 * @see     https://github.com/idmarinas/user-bundle/
 *
 * @license https://github.com/idmarinas/user-bundle/blob/master/LICENSE.txt
 * @author  Iván Diaz Marinas (IDMarinas)
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\User\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

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

	public function isEqualTo (UserInterface $user): bool
	{
		// -- Solo se permite una sesión en un único dispositivo y firewall
		return !(
			$this->getPassword() !== $user->getPassword()
			|| $this->getSalt() !== $user->getSalt()
			|| $this->getUserIdentifier() !== $user->getUserIdentifier()
			|| $this->getSessionId() !== $user->getSessionId()
		);
	}
}