<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "idmarinas" on 17/12/2024, 11:59
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
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Fixtures\Entity;

use Idm\Bundle\User\Traits\Entity\SecurityTrait;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class FakeUser implements UserInterface, PasswordAuthenticatedUserInterface
{
	use SecurityTrait;

	public function getRoles (): array
	{
		return [];
	}

	public function getUserIdentifier (): string
	{
		return '';
	}

	public function getUsername (): string
	{
		return $this->getUserIdentifier();
	}

	public function getPassword (): string
	{
		return '';
	}
}
