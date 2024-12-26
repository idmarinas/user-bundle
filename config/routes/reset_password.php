<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 26/12/2024, 13:51
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    reset_password.php
 * @date    26/12/2024
 * @time    13:50
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

use Idm\Bundle\User\Controller\ResetPasswordController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
	// @formatter:off
	$routes
		->import(resource: ResetPasswordController::class, type: 'attribute')
		->prefix('/user', false)
		->namePrefix('idm_user_')
	;
	// @formatter:on
};
