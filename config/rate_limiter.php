<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 29/12/2024, 22:39
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    rate_limiter.php
 * @date    29/12/2024
 * @time    22:39
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Security\Http\RateLimiter\DefaultLoginRateLimiter;

return static function (ContainerConfigurator $container) {
	$container->extension('framework', [
		'rate_limiter' => [
			'idm_user.login.username_ip.main'  => [
				'policy' => 'token_bucket',
				'limit'  => 5,
				'rate'   => [
					'interval' => '5 minutes',
				],
			],
			'idm_user.login.ip.main'           => [
				'policy'   => 'sliding_window',
				'limit'    => 25,
				'interval' => '15 minutes',
			],
			'idm_user.login.username_ip.admin' => [
				'policy' => 'token_bucket',
				'limit'  => 3,
				'rate'   => [
					'interval' => '5 minutes',
				],
			],
			'idm_user.login.ip.admin'          => [
				'policy'   => 'sliding_window',
				'limit'    => 10,
				'interval' => '15 minutes',
			],
		],
	]);

	if ('dev' == $container->env()) {
		$container->extension('framework', [
			'rate_limiter' => [
				'idm_user.login.username_ip.main'  => [
					'limit' => 300,
				],
				'idm_user.login.ip.main'           => [
					'limit' => 300,
				],
				'idm_user.login.username_ip.admin' => [
					'limit' => 300,
				],
				'idm_user.login.ip.admin'          => [
					'limit' => 300,
				],
			],
		]);
	}

	// @formatter:off
	$container->services()
		->set('idm_user.rate_limiter.login.main', DefaultLoginRateLimiter::class)
			->args([
				'$globalFactory' => service('limiter.idm_user.login.ip.main'),
				'$localFactory' => service('limiter.idm_user.login.username_ip.main'),
				'$secret' => param('kernel.secret'),
			])
		->set('idm_user.rate_limiter.login.admin', DefaultLoginRateLimiter::class)
			->args([
				'$globalFactory' => service('limiter.idm_user.login.ip.admin'),
				'$localFactory' => service('limiter.idm_user.login.username_ip.admin'),
				'$secret' => param('kernel.secret'),
			])
	;
	// @formatter:on
};
