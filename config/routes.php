<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 10/12/2024, 10:25
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
 * @since   1.1.0
 */

use Idm\Bundle\User\Controller\ResetPasswordController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
	// @formatter:off
	$routes
		->import(resource: ResetPasswordController::class, type: 'annotation')
			->prefix('/user', false)
			->namePrefix('idm_user_')
	;
	// @formatter:on
};
