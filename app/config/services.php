<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/02/2025, 23:02
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

use App\Controller\LoginController;
use App\Controller\ProfileController;
use App\Controller\RegistrationController;
use App\Controller\ResetPasswordController;
use App\Repository\User\ResetPasswordRequestRepository;
use App\Repository\User\UserRepository;

return static function (ContainerConfigurator $container): void {
	// @formatter:off
	$container
		->services()
			->set(UserRepository::class)->public()->autoconfigure()->autowire()
			->set(ResetPasswordRequestRepository::class, ResetPasswordRequestRepository::class)->public()->autoconfigure()->autowire()

			// Register ResetPasswordController
			->set(ResetPasswordController::class, ResetPasswordController::class)->autoconfigure()->autowire()
			// Register LoginController
			->set(LoginController::class, LoginController::class)->autoconfigure()->autowire()
			// Register ProfileController
			->set(ProfileController::class, ProfileController::class)->autoconfigure()->autowire()
			// Register RegistrationController
			->set(RegistrationController::class, RegistrationController::class)
				->arg('$emailVerifier', service('idm_user.service.email_verifier'))
				->autoconfigure()
				->autowire()
	;
	// @formatter:on
};
