<?php

/**
 * Copyright 2023-2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/12/2024, 23:12
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
use Idm\Bundle\User\Model\AbstractUser;
use Idm\Bundle\User\Model\AbstractUserConnectionLog;
use Idm\Bundle\User\Model\AbstractUserPremium;
use Idm\Bundle\User\Repository\ResetPasswordRequestRepository;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use function dirname;

final class IdmUserExtension extends Extension implements PrependExtensionInterface
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
		$container->prependExtensionConfig('security', [
			'password_hashers' => [
				PasswordAuthenticatedUserInterface::class => 'auto',
			],
		]);
		$container->prependExtensionConfig('doctrine', [
			'orm' => [
				'resolve_target_entities' => [
					AbstractUser::class              => 'App\Entity\User\User',
					AbstractUserPremium::class       => 'App\Entity\User\UserPremium',
					AbstractUserConnectionLog::class => 'App\Entity\User\UserConnectionLog',
				],
			],
		]);
	}
}
