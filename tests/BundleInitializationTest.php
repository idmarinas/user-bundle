<?php

/**
 * Copyright 2024-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/09/2026, 20:17
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

declare(strict_types=1);

namespace Idm\Bundle\User\Tests;

use App\Kernel;
use Idm\Bundle\User\Security\Checker\UserAdminChecker;
use Idm\Bundle\User\Security\Checker\UserChecker;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class BundleInitializationTest extends KernelTestCase
{
	use CreateKernelCaseTrait;

	public function testInitBundle(): void
	{
		// Boot the kernel.
		$kernel = self::bootKernel([
			'config' => static function (Kernel $kernel): void {
//				$kernel->addExtraBundle(BundleName::class);
//				$kernel->addExtraConfig('path/to/file.php');
//				$kernel->addExtraConfig(['extension_name' => ['key_1' => 'value_1']);
//				$kernel->addExtraRoutesFile('path/to/file.php');
			},
		]);

		$this->assertTrue($kernel->getContainer()->has('kernel'));

		$container = static::getContainer();

		$this->assertTrue($container->has('idm_user.service.email_verifier'));
		$this->assertTrue($container->has(UserChecker::class));
		$this->assertTrue($container->has(UserAdminChecker::class));
	}
}
