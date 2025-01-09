<?php

/**
 * Copyright 2023-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 09/01/2025, 18:21
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    IdmUserBundle.php
 * @date    20/12/2023
 * @time    22:28
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\User;

use Idm\Bundle\User\Repository\ResetPasswordRequestRepository;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

final class IdmUserBundle extends AbstractBundle
{
	public function prependExtension (ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		$container->import(dirname(__DIR__) . '/config/rate_limiter.php');

		$builder->prependExtensionConfig('symfonycasts_reset_password', [
			'request_password_repository' => ResetPasswordRequestRepository::class,
		]);

		$builder->prependExtensionConfig('security', [
			'password_hashers' => [
				PasswordAuthenticatedUserInterface::class => 'auto',
			],
		]);
	}

	public function loadExtension (array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		$container->import(dirname(__DIR__) . '/config/services.php');
	}
}
