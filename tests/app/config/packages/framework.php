<?php
/**
 * Copyright 2024-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 24/09/2026, 19:35
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

return static function (ContainerConfigurator $container) {
	$container->extension('framework', [
		'secret'                => 'test',
		'http_method_override'  => false,
		'test'                  => true,
		'default_locale'        => 'en',
		'enabled_locales'       => ['en'],
		'handle_all_throwables' => true,
		'csrf_protection'       => [
			'enabled' => true,
		],
		'assets'                => [
			'enabled' => true,
		],
		'form'                  => [
			'enabled'         => true,
			'csrf_protection' => [
				'enabled' => true,
			],
		],
		'http_cache'            => [
			'enabled' => false,
			'debug'   => true,
		],
		'router'                => [
			'enabled' => true,
			'utf8'    => true,
		],
		'session'               => [
			'enabled'            => true,
			'handler_id'         => null,
			'cookie_secure'      => 'auto',
			'cookie_samesite'    => 'lax',
			'storage_factory_id' => 'session.storage.factory.mock_file',
		],
		'validation'            => [
			'enabled'                  => true,
			'email_validation_mode'    => 'html5',
			'not_compromised_password' => [
				'enabled' => false,
			],
		],
		'property_access'       => [
			'enabled' => true,
		],
		'php_errors'            => [
			'log' => true,
		],
		'messenger'             => [
			'enabled'    => false,
			'routing'    => [
				'Symfony\Component\Mailer\Messenger\SendEmailMessage' => [
					'senders' => ['sync'],
				],
			],
			'transports' => [
				'sync' => 'in-memory://',
			],
		],
		'mailer'                => [
			'enabled'  => true,
			'dsn'      => $_ENV['MAILER_DSN'] ?? 'null://null',
			'envelope' => [
				'sender' => 'idm_user@test.bundle',
			],
			'headers'  => [
				'From' => 'IDMarinas User Bundle <idm_user@test.bundle>',
			],
		],
		'uid'                   => [
			'enabled'                 => true,
			'default_uuid_version'    => 7,
			'time_based_uuid_version' => 7,
		],
	]);

	$container->import(__DIR__.'/rate_limiter.php');
};
