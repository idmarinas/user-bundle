<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 15/02/2025, 11:59
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    factories.php
 * @date    17/12/2024
 * @time    21:41
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container) {
	// @formatter:off
	$container
		->services()
			->load('Factory\\', dirname(__DIR__, 2) . '/factories')
			->public()
			->autowire()
			->autoconfigure()
	;
	// @formatter:on
};
