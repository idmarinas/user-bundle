<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 30/12/2024, 17:24
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    mailer.php
 * @date    27/12/2024
 * @time    14:11
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
	$container->extension('framework', [
		'mailer' => [
			'dsn'      => $_ENV['MAILER_DSN'] ?? 'null://null',
			'envelope' => [
				'sender' => 'idm_user@test.bundle',
			],
			'headers'  => [
				'From' => 'IDMarinas User Bundle <idm_user@test.bundle>',
			],
		],
	]);
};
