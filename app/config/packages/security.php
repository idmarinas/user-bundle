<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 31/12/2024, 13:15
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

use App\Entity\User\User;
use Idm\Bundle\User\Security\Checker\UserAdminChecker;
use Idm\Bundle\User\Security\Checker\UserChecker;
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
			'admin' => [
				'host'             => '^admin\.localhost$',
				'logout'           => [
					'path' => '/logout',
				],
				'provider'         => 'idm_user_provider',
				'user_checker'     => UserAdminChecker::class,
				'form_login'       => [
					'login_path'          => 'idm_user_login',
					'check_path'          => 'idm_user_login',
					'enable_csrf'         => true,
					'form_only'           => true,
					'default_target_path' => 'idm_user_profile_index',
				],
				'login_throttling' => [
					'limiter' => 'idm_user.rate_limiter.login.admin',
				],
			],
			'main'  => [
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
		'role_hierarchy'   => [
			'ROLE_ADMIN'       => 'ROLE_USER',
			'ROLE_SUPER_ADMIN' => ['ROLE_ADMIN', 'ROLE_ALLOWED_TO_SWITCH'],
		],
	]);
};
