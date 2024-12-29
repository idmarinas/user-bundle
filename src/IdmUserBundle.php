<?php

/**
 * Copyright 2023-2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 29/12/2024, 23:04
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

use Idm\Bundle\User\Model\Entity\AbstractUser;
use Idm\Bundle\User\Model\Entity\AbstractUserConnectionLog;
use Idm\Bundle\User\Model\Entity\AbstractUserPremium;
use Idm\Bundle\User\Repository\ResetPasswordRequestRepository;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

final class IdmUserBundle extends AbstractBundle
{
	public function prependExtension (ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		$container->extension('symfonycasts_reset_password', [
			'request_password_repository' => ResetPasswordRequestRepository::class,
		]);

		$container->extension('security', [
			'password_hashers' => [
				PasswordAuthenticatedUserInterface::class => 'auto',
			],
		]);

		$container->extension('doctrine', [
			'orm' => [
				'resolve_target_entities' => [
					AbstractUser::class              => 'App\Entity\User\User',
					AbstractUserPremium::class       => 'App\Entity\User\UserPremium',
					AbstractUserConnectionLog::class => 'App\Entity\User\UserConnectionLog',
				],
			],
		]);
	}

	public function loadExtension (array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		$container->import(dirname(__DIR__) . '/config/services.php');
	}
}
