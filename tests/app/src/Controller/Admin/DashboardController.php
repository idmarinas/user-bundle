<?php
/**
 * Copyright 2025-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/09/2026, 19:45
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    DashboardController.php
 * @date    25/02/2025
 * @time    14:33
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.6
 */

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

#[AdminDashboard('/admin', 'dashboard')]
class DashboardController extends AbstractDashboardController
{
	public function configureDashboard(): Dashboard
	{
		return Dashboard::new()
			->setTitle('Html')
		;
	}

	public function configureMenuItems(): iterable
	{
		yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
		yield MenuItem::linkTo(UserCrudController::class, 'User', 'fas fa-list');
	}
}
