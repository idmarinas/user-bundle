<?php

/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/12/2024, 17:30
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
	}
}
