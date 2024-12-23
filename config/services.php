<?php

/**
 * Copyright 2023-2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/12/2024, 17:39
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

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\User\Controller\ResetPasswordController;
use Idm\Bundle\User\Repository\ResetPasswordRequestRepository;
use Idm\Bundle\User\Security\EmailVerifier;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

return static function (ContainerConfigurator $container) {
	// @formatter:off
	$container
		->services()
		  // Register EmailVerifier service
			->set('idm_user.service.email_verifier', EmailVerifier::class)
				->public()
				->args([
					service(VerifyEmailHelperInterface::class),
					service(MailerInterface::class),
					service(EntityManagerInterface::class),
					service(RequestStack::class),
				])
			// Register ResetPasswordRequestRepository service
			->set(ResetPasswordRequestRepository::class, ResetPasswordRequestRepository::class)
				->public()
				->args([
					service(ManagerRegistry::class)
				])
			// Register ResetPasswordController
			->set(ResetPasswordController::class, ResetPasswordController::class)
				->public()
				->call('setContainer', [service_locator([
					'router' => service('router'),
					'request_stack' => service('request_stack'),
					'session' => service('argument_resolver.session'),
					'twig' => service('twig'),
					'form.factory' => service('form.factory'),
				])])
				->autoconfigure()
				->autowire()
	;
	// @formatter:on
};
