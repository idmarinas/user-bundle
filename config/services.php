<?php

/**
 * Copyright 2023-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/02/2025, 22:45
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

use Idm\Bundle\User\Security\Checker\UserAdminChecker;
use Idm\Bundle\User\Security\Checker\UserChecker;
use Idm\Bundle\User\Security\EmailVerifier;

return static function (ContainerConfigurator $container) {
	// @formatter:off
	$container
		->services()
			// Register EmailVerifier service
			->set('idm_user.service.email_verifier', EmailVerifier::class)->public()->autowire()->autoconfigure()
			// Register UserChecker
			->set(UserChecker::class, UserChecker::class)->public()->autoconfigure()->autowire()
			// Register UserAdminChecker
			->set(UserAdminChecker::class, UserAdminChecker::class)->public()->autoconfigure()->autowire()
	;
	// @formatter:on
};
