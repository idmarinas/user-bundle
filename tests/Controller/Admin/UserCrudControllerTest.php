<?php

/**
 * Copyright 2025-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 07/10/2026, 15:56
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

declare(strict_types=1);

namespace Idm\Bundle\User\Tests\Controller\Admin;

use App\Controller\Admin\DashboardController;
use App\Controller\Admin\UserCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;

final class UserCrudControllerTest extends AbstractCrudTestCase
{
	public function testIndexPage()
	{
		// Symfony 7.0 installs symfony/twig-bridge 7.0.x, the only branch that never received the
		// fix for `Twig\Node\EmptyNode` ("EmptyNode cannot have children."). The fix
		// (symfony/symfony#58964) was released for 5.4.48, 6.4.16 and 7.1.9, but never backported
		// to the 7.0 line (EOL). With twig/twig >= 3.16 its templates using `{% trans_default_domain %}`
		// fail at compile time, so this test only runs where that compatibility issue does not apply.
		if (Kernel::VERSION_ID >= 70000 && Kernel::VERSION_ID < 70100) {
			$this->markTestSkipped(
				'EasyAdmin cannot compile its Twig templates on Symfony 7.0 '
				.'(symfony/twig-bridge 7.0.x has no fix for Twig EmptyNode; requires twig-bridge >= 7.1.9).'
			);
		}

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
