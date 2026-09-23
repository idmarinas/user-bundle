<?php
/**
 * Copyright $originalComment.match("Copyright (\d+)", 1, "-",$today.year)2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/09/2026, 18:07
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    profile.php
 * @date    26/12/2024
 * @time    13:57
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

use App\Controller\ProfileController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes): void {
	// @formatter:off
	$routes
		->import(resource: ProfileController::class, type: 'attribute')
		->prefix('/user', false)
		->namePrefix('idm_user_')
	;
	// @formatter:on
};
