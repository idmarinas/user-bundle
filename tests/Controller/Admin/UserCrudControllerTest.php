<?php
/**
 * Copyright 2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/09/2026, 20:08
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserCrudControllerTest.php
 * @date    27/09/2026
 * @time    20:11
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.2.0
 */

declare(strict_types=1);

/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/02/2025, 13:22
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserCrudControllerTest.php
 * @date    25/02/2025
 * @time    14:35
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.6
 */

namespace Idm\Bundle\User\Tests\Controller\Admin;

use App\Controller\Admin\DashboardController;
use App\Controller\Admin\UserCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;
use Symfony\Component\HttpFoundation\Request;

/** @group ignore */
final class UserCrudControllerTest extends AbstractCrudTestCase
{
	public function testIndexPage()
	{
		$this->client->request(Request::METHOD_GET, $this->generateIndexUrl());

		$this->assertResponseIsSuccessful();
	}

	protected function getControllerFqcn(): string
	{
		return UserCrudController::class;
	}

	protected function getDashboardFqcn(): string
	{
		return DashboardController::class;
	}
}
