<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 30/12/2024, 24:12
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    session.php
 * @date    27/12/2024
 * @time    14:13
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
	$container->extension('framework', [
		'session' => [
			'handler_id'         => null,
			'cookie_secure'      => true,
			'cookie_samesite'    => 'lax',
			'storage_factory_id' => 'session.storage.factory.mock_file',
		],
	]);
};
