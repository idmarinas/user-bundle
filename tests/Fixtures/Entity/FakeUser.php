<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/12/2024, 22:02
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    FakeUser.php
 * @date    05/12/2024
 * @time    17:50
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Tests\Fixtures\Entity;

use Idm\Bundle\User\Entity\Traits\SecurityTrait;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class FakeUser implements UserInterface, PasswordAuthenticatedUserInterface
{
	use SecurityTrait;

	public function getRoles (): array
	{
		return [];
	}

	public function getUsername (): string
	{
		return $this->getUserIdentifier();
	}

	public function getUserIdentifier (): string
	{
		return '';
	}

	public function getPassword (): string
	{
		return '';
	}
}
