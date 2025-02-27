<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 25/02/2025, 15:35
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

use App\Controller\Admin\DashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminRouteLoader;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
	// @formatter:off
	$routes->import('routes/login.php');
	$routes->import('routes/profile.php');
	$routes->import('routes/registration.php');
	$routes->import('routes/reset_password.php');

	$routes
		->import(DashboardController::class, AdminRouteLoader::ROUTE_LOADER_TYPE)
	;
	// @formatter:on
};
