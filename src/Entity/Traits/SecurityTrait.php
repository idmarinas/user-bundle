<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 3/1/24, 9:27
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    SecurityTrait.php
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

trait SecurityTrait
{
	/**
	 * @var string The hashed password
	 */
	#[ORM\Column(type: Types::STRING)]
	protected string $password = '';

	/**
	 * @see \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface
	 */
	public function getPassword (): string
	{
		return $this->password;
	}

	public function setPassword (string $password): static
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Returning a salt is only needed, if you are not using a modern
	 * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
	 *
	 * @see \Symfony\Component\Security\Core\User\UserInterface
	 */
	public function getSalt (): ?string
	{
		return null;
	}

	/**
	 * @see \Symfony\Component\Security\Core\User\UserInterface
	 */
	public function eraseCredentials (): void
	{
		// If you store any temporary, sensitive data on the user, clear it here
		// $this->plainPassword = null;
	}

	public function eraseDataForCache (): static
	{
		$this->password = null;

		return $this;
	}
}