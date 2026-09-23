<?php

/**
 * Copyright 2026-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/09/2026, 20:20
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

		$this->assertCount(20, $routes);
		$this->assertInstanceOf(Route::class, $routeCollection->get('idm_user_login_web'));
		$this->assertInstanceOf(Route::class, $routeCollection->get('idm_user_profile_index'));
		$this->assertInstanceOf(Route::class, $routeCollection->get('idm_user_profile_change_password'));
	}
}
