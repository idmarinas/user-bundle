<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 25/02/2025, 14:46
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    framework.php
 * @date    27/12/2024
 * @time    13:33
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
	$container->extension('framework', [
		'secret'                => 'test',
		'test'                  => true,
		'http_method_override'  => false,
		'handle_all_throwables' => true,
		'php_errors'            => [
			'log' => true,
		],
		'form'                  => true,
		'assets'                => true,
		'uid'                   => [
			'default_uuid_version'    => 7,
			'time_based_uuid_version' => 7,
		],
	]);
};
