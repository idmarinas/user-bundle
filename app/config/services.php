<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/01/2025, 10:56
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    services.php
 * @date    27/12/2024
 * @time    14:14
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Repository\User\ResetPasswordRequestRepository;
use App\Repository\User\UserRepository;

return static function (ContainerConfigurator $container): void {
	// @formatter:off
	$container
		->services()
			->set(UserRepository::class)
				->public()
				->autoconfigure()
				->autowire()

			->set(ResetPasswordRequestRepository::class, ResetPasswordRequestRepository::class)
				->public()
				->autoconfigure()
				->autowire()
	;
	// @formatter:on
};
