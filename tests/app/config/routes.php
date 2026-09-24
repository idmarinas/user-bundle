<?php
/**
 * Copyright 2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 24/09/2026, 19:46
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
use Symfony\Bundle\FrameworkBundle\Controller\TemplateController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes): void {
//	$routes->import('routes/web_profiler.php');
	$routes->import('routes/login.php');
	$routes->import('routes/profile.php');
	$routes->import('routes/registration.php');
	$routes->import('routes/reset_password.php');

	$routes->import('security.route_loader.logout', 'service')->methods(['GET']);
	$routes->import(DashboardController::class, AdminRouteLoader::ROUTE_LOADER_TYPE);

	$routes
		->add('app_home', '/')
		->methods(['GET'])
		->controller(TemplateController::class)
		->defaults([
			'template' => '@IdmUser/base.html.twig',
		])
	;
};
