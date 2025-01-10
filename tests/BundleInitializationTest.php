<?php

/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 10/01/2025, 19:07
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    BundleInitializationTest.php
 * @date    02/01/2024
 * @time    19:09
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\User\Tests;

use Idm\Bundle\User\Security\Checker\UserAdminChecker;
use Idm\Bundle\User\Security\Checker\UserChecker;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BundleInitializationTest extends KernelTestCase
{
	public function testInitBundle (): void
	{
		// Boot the kernel.
		static::bootKernel();

		$this->assertTrue(true);

		$container = static::getContainer();

		$this->assertTrue($container->has('idm_user.service.email_verifier'));
		$this->assertTrue($container->has(UserChecker::class));
		$this->assertTrue($container->has(UserAdminChecker::class));
	}
}
