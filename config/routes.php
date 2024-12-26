<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 26/12/2024, 14:00
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    routes.php
 * @date    09/12/2024
 * @time    19:05
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
	// @formatter:off
	$routes->import('routes/login.php');
	$routes->import('routes/profile.php');
	$routes->import('routes/registration.php');
	$routes->import('routes/reset_password.php');
	// @formatter:on
};
