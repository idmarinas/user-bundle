<?php

/**
 * Copyright 2023-2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "idmarinas" on 26/12/2024, 21:00
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    services.php
 * @date    20/12/2023
 * @time    21:26
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Idm\Bundle\User\Controller\LoginController;
use Idm\Bundle\User\Controller\ResetPasswordController;
use Idm\Bundle\User\Repository\ResetPasswordRequestRepository;
use Idm\Bundle\User\Security\Checker\UserAdminChecker;
use Idm\Bundle\User\Security\Checker\UserChecker;
use Idm\Bundle\User\Security\EmailVerifier;

return static function (ContainerConfigurator $container) {
	// @formatter:off
	$container
		->services()
		// Register EmailVerifier service
		->set('idm_user.service.email_verifier', EmailVerifier::class)->public()->autowire()->autoconfigure()
		// Register ResetPasswordRequestRepository service
		->set(ResetPasswordRequestRepository::class, ResetPasswordRequestRepository::class)->public()->autowire()->autoconfigure()
		// Register ResetPasswordController
		->set(ResetPasswordController::class, ResetPasswordController::class)->public()->autoconfigure()->autowire()
		// Register LoginController
		->set(LoginController::class, LoginController::class)->public()->autoconfigure()->autowire()
		// Register UserChecker
		->set(UserChecker::class, UserChecker::class)->public()->autowire()->autoconfigure()
		// Register UserAdminChecker
		->set(UserAdminChecker::class, UserAdminChecker::class)->public()->autowire()->autoconfigure()
	;
	// @formatter:on
};
