<?php
/**
 * Copyright 2025-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/02/2025, 13:22
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserCrudController.php
 * @date    25/02/2025
 * @time    14:34
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.6
 */

namespace App\Controller\Admin;

use App\Entity\User\User;
use Idm\Bundle\User\Model\Controller\Admin\AbstractUserCrudController;

class UserCrudController extends AbstractUserCrudController
{
	public static function getEntityFqcn(): string
	{
		return User::class;
	}
}
