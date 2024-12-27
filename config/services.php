<?php

/**
 * Copyright 2023-2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/12/2024, 18:58
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
use Idm\Bundle\User\Controller\ProfileController;
use Idm\Bundle\User\Controller\RegistrationController;
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
		->set(ResetPasswordController::class, ResetPasswordController::class)->autoconfigure()->autowire()
		// Register LoginController
		->set(LoginController::class, LoginController::class)->autoconfigure()->autowire()
		// Register ProfileController
		->set(ProfileController::class, ProfileController::class)->autoconfigure()->autowire()
		// Register RegistrationController
		->set(RegistrationController::class, RegistrationController::class)
			->arg('$emailVerifier', service('idm_user.service.email_verifier'))
			->bind('$formLoginAuthenticatorMain', service('security.authenticator.form_login.main'))
			->autoconfigure()
			->autowire()
		// Register UserChecker
		->set(UserChecker::class, UserChecker::class)->public()->autoconfigure()->autowire()
		// Register UserAdminChecker
		->set(UserAdminChecker::class, UserAdminChecker::class)->public()->autoconfigure()->autowire()
	;
	// @formatter:on
};
