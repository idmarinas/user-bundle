<?php

/**
 * Copyright 2023-2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/12/2024, 16:45
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    IdmUserExtension.php
 * @date    20/12/2023
 * @time    15:22
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\User\DependencyInjection;

use Exception;
use Idm\Bundle\User\Repository\ResetPasswordRequestRepository;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use function dirname;

class IdmUserExtension extends Extension implements PrependExtensionInterface
{
	/**
	 * @inheritdoc
	 * @throws Exception
	 */
	public function load (array $configs, ContainerBuilder $container): void
	{
		$loader = new PhpFileLoader($container, new FileLocator(dirname(__DIR__, 2) . '/config'));

		$loader->load('services.php');
	}

	public function prepend (ContainerBuilder $container): void
	{
		$container->prependExtensionConfig('symfonycasts_reset_password', [
			'request_password_repository' => ResetPasswordRequestRepository::class,
		]);
	}
}
