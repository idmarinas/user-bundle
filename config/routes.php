<?php
/**
 * Copyright 2026-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 07/10/2026, 12:53
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    routes.php
 * @date    06/10/2026
 * @time    18:36
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.3.0
 */

use Idm\Bundle\User\Controller\LoginController;
use Idm\Bundle\User\Controller\ProfileController;
use Idm\Bundle\User\Controller\RegistrationController;
use Idm\Bundle\User\Controller\ResetPasswordController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes): void {
	$routes->import(LoginController::class, 'attribute')->prefix('/user')->namePrefix('idm_user_');
	$routes->import(RegistrationController::class, 'attribute')->prefix('/user')->namePrefix('idm_user_');
	$routes->import(ProfileController::class, 'attribute')->prefix('/user')->namePrefix('idm_user_');
	$routes->import(ResetPasswordController::class, 'attribute')->prefix('/user')->namePrefix('idm_user_');
};
