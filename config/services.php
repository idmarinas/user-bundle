<?php

/**
 * Copyright 2023-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 07/10/2026, 13:01
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
use Idm\Bundle\User\Controller\LoginController;
use Idm\Bundle\User\Controller\ProfileController;
use Idm\Bundle\User\Controller\RegistrationController;
use Idm\Bundle\User\Controller\ResetPasswordController;
use Idm\Bundle\User\Security\Checker\UserAdminChecker;
use Idm\Bundle\User\Security\Checker\UserChecker;
use Idm\Bundle\User\Security\EmailVerifier;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

return static function (ContainerConfigurator $container): void {
	// @formatter:off
	$container->services()
			// Register EmailVerifier service
		->set('idm_user.service.email_verifier', EmailVerifier::class)->private()
			->args([
				service(VerifyEmailHelperInterface::class),
				service(MailerInterface::class),
				service(EntityManagerInterface::class),
				service(RequestStack::class),
			])
			->alias(EmailVerifier::class, 'idm_user.service.email_verifier')
		// Register UserChecker
		->set(UserChecker::class, UserChecker::class)
			->args([
				service(AccessDecisionManagerInterface::class),
				service(RequestStack::class),
			])
		// Register UserAdminChecker
		->set(UserAdminChecker::class, UserAdminChecker::class)
			->args([
				service(AccessDecisionManagerInterface::class),
				service(RequestStack::class),
			])
			// Controllers
		->set(LoginController::class)->private()
			->call('setContainer', [service(ContainerInterface::class)])
			->tag('controller.service_arguments')
			->tag('container.service_subscriber')
		->set(ProfileController::class)->private()
			->call('setContainer', [service(ContainerInterface::class)])
			->tag('controller.service_arguments')
			->tag('container.service_subscriber')
		->set(RegistrationController::class)->private()
			->args(['$emailVerifier' => service('idm_user.service.email_verifier'),
				'$entityManager' => service(EntityManagerInterface::class),
				'$translator' => service(TranslatorInterface::class),
				'$passwordHasher' => service(UserPasswordHasherInterface::class),
			])
			->call('setContainer', [service(ContainerInterface::class)])
			->tag('controller.service_arguments')
			->tag('container.service_subscriber')
		->set(ResetPasswordController::class)->private()
			->args([
				'$resetPasswordHelper' => service(ResetPasswordHelperInterface::class),
				'$entityManager' => service(EntityManagerInterface::class),
			])
			->call('setContainer', [service(ContainerInterface::class)])
			->tag('controller.service_arguments')
			->tag('container.service_subscriber')
	;
};
