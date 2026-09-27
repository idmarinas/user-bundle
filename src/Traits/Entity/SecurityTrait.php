<?php
/**
 * Copyright 2024-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/09/2026, 22:33
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
 * @since   1.0.0
 */

namespace Idm\Bundle\User\Traits\Entity;

use Deprecated;
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
	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): static
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
	public function getSalt(): ?string
	{
		return null;
	}

	/**
	 * @see \Symfony\Component\Security\Core\User\UserInterface
	 */
	#[Deprecated]
	public function eraseCredentials(): void
	{
		// If you store any temporary, sensitive data on the user, clear it here
		// $this->plainPassword = '';
		$this->password = '';
	}

	/**
	 * Prevents the hashed password from being put into the session storage.
	 *
	 * @see \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface
	 */
	public function __serialize(): array
	{
		$data = (array)$this;
		unset($data["\0".self::class."\0password"]);

		return $data;
	}
}
