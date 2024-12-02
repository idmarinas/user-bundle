<?php

/**
 * Copyright 2023-2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 2/12/24, 21:26
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
use Idm\Bundle\User\Security\EmailVerifier;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

return static function (ContainerConfigurator $container) {
	$container
		->services()
		->set(EmailVerifier::class, EmailVerifier::class)
		->args([
			service(VerifyEmailHelperInterface::class),
			service(MailerInterface::class),
			service(EntityManagerInterface::class),
			service(RequestStack::class),
		])
	;
};