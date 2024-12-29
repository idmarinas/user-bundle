<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 28/12/2024, 11:37
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    messenger.php
 * @date    28/12/2024
 * @time    11:36
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
	$container->extension('framework', [
		'messenger' => [
			'transports' => [
				'sync' => 'in-memory://',
			],
			'routing'    => [
				'Symfony\\Component\\Mailer\\Messenger\\SendEmailMessage' => 'sync',
			],
		],
	]);
};
