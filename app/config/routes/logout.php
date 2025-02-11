<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 02/01/2025, 12:57
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    logout.php
 * @date    25/12/2024
 * @time    20:56
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

//:
//resource: security.route_loader.logout
//    type: service

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
	// @formatter:off
	$routes
		->import(resource: 'security.route_loader.logout', type: 'service')
	;
	// @formatter:on
};
