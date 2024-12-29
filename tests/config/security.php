<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 29/12/2024, 23:09
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    security.php
 * @date    27/12/2024
 * @time    14:14
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Idm\Bundle\User\Security\Checker\UserChecker;
use Idm\Bundle\User\Tests\App\Entity\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

return static function (ContainerConfigurator $container) {
	$container->extension('security', [
		'providers'        => [
			'idm_user_provider' => [
				'entity' => [
					'class'    => User::class,
					'property' => 'email',
				],
			],
		],
		'firewalls'        => [
			'main' => [
				'logout'           => [
					'path' => '/logout',
				],
				'provider'         => 'idm_user_provider',
				'user_checker'     => UserChecker::class,
				'form_login'       => [
					'login_path'          => 'idm_user_login',
					'check_path'          => 'idm_user_login',
					'enable_csrf'         => true,
					'form_only'           => true,
					'default_target_path' => 'idm_user_profile_index',
				],
				'login_throttling' => [
					'limiter' => 'idm_user.rate_limiter.login.main',
				],
			],
		],
		'password_hashers' => [
			PasswordAuthenticatedUserInterface::class => [
				'algorithm'   => 'auto',
				'cost'        => 4,
				'time_cost'   => 3,
				'memory_cost' => 10,
			],
		],
	]);
};
