<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/12/2024, 15:17
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractKernelTest.php
 * @date    05/12/2024
 * @time    13:02
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Tests;

use Idm\Bundle\User\IdmUserBundle;
use Nyholm\BundleTest\TestKernel;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractKernelTest extends KernelTestCase
{
	protected static function getKernelClass (): string
	{
		return TestKernel::class;
	}

	protected static function createKernel (array $options = []): KernelInterface
	{
		/**
		 * @var TestKernel $kernel
		 */
		$kernel = parent::createKernel($options);
		$kernel->addTestBundle(FrameworkBundle::class);
		$kernel->addTestBundle(IdmUserBundle::class);
		$kernel->addTestConfig(function (ContainerBuilder $container) {
			$container->loadFromExtension('framework', [
				'form'       => true,
				'validation' => true,
				'router'     => [
					'utf8' => true,
				],
			]);
		});

		return $kernel;
	}
}
