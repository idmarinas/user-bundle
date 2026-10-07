<?php

/**
 * Copyright 2026-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 07/10/2026, 13:53
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    BundleRoutingTest.php
 * @date    22/01/2025
 * @time    13:07
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   3.4.0
 */

declare(strict_types=1);

namespace Idm\Bundle\User\Tests;

use App\Controller\LoginController as AppLoginController;
use App\Controller\ProfileController as AppProfileController;
use App\Controller\RegistrationController as AppRegistrationController;
use App\Controller\ResetPasswordController as AppResetPasswordController;
use App\Kernel;
use Idm\Bundle\User\Controller\LoginController;
use Idm\Bundle\User\Controller\ProfileController;
use Idm\Bundle\User\Controller\RegistrationController;
use Idm\Bundle\User\Controller\ResetPasswordController;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

final class BundleRoutingTest extends KernelTestCase
{
	use CreateKernelCaseTrait;

	public function testAddRoutingFile(): void
	{
		$kernel = self::bootKernel();

		$container = $kernel->getContainer();
		$container = $container->get('test.service_container');
		/**
		 * @var RouterInterface $router
		 */
		$router = $container->get(RouterInterface::class);
		$routeCollection = $router->getRouteCollection();
		$routes = $routeCollection->all();

		$this->assertCount(22, $routes);

		$routeLogin = $routeCollection->get('idm_user_login_web');
		$routeProfile = $routeCollection->get('idm_user_profile_index');
		$routeReset = $routeCollection->get('idm_user_forgot_password_request');
		$routeCreate = $routeCollection->get('idm_user_registration_register_web');

		$this->assertInstanceOf(Route::class, $routeLogin);
		$this->assertInstanceOf(Route::class, $routeProfile);
		$this->assertInstanceOf(Route::class, $routeReset);
		$this->assertInstanceOf(Route::class, $routeCreate);

		$this->assertStringStartsWith(LoginController::class, $routeLogin->getDefault('_controller'));
		$this->assertStringStartsWith(ProfileController::class, $routeProfile->getDefault('_controller'));
		$this->assertStringStartsWith(ResetPasswordController::class, $routeReset->getDefault('_controller'));
		$this->assertStringStartsWith(RegistrationController::class, $routeCreate->getDefault('_controller'));
	}

	public function testChangeRoutes(): void
	{
		$kernel = self::bootKernel([
			'config' => static function (Kernel $kernel): void {
				$kernel->addExtraRoutesFile(__DIR__.'/app/config/routes/login.php');
				$kernel->addExtraRoutesFile(__DIR__.'/app/config/routes/profile.php');
				$kernel->addExtraRoutesFile(__DIR__.'/app/config/routes/registration.php');
				$kernel->addExtraRoutesFile(__DIR__.'/app/config/routes/reset_password.php');
			},
		]);

		$container = $kernel->getContainer();
		$container = $container->get('test.service_container');
		/**
		 * @var RouterInterface $router
		 */
		$router = $container->get(RouterInterface::class);
		$routeCollection = $router->getRouteCollection();
		$routes = $routeCollection->all();

		$this->assertCount(22, $routes);

		$routeLogin = $routeCollection->get('idm_user_login_web');
		$routeProfile = $routeCollection->get('idm_user_profile_index');
		$routeReset = $routeCollection->get('idm_user_forgot_password_request');
		$routeCreate = $routeCollection->get('idm_user_registration_register_web');

		$this->assertInstanceOf(Route::class, $routeLogin);
		$this->assertInstanceOf(Route::class, $routeProfile);
		$this->assertInstanceOf(Route::class, $routeReset);
		$this->assertInstanceOf(Route::class, $routeCreate);

		$this->assertStringStartsWith(AppLoginController::class, $routeLogin->getDefault('_controller'));
		$this->assertStringStartsWith(AppProfileController::class, $routeProfile->getDefault('_controller'));
		$this->assertStringStartsWith(AppResetPasswordController::class, $routeReset->getDefault('_controller'));
		$this->assertStringStartsWith(AppRegistrationController::class, $routeCreate->getDefault('_controller'));
	}
}
