<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 10/01/2025, 14:05
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserRolesEnum.php
 * @date    10/01/2025
 * @time    13:39
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Enums;

enum UserRolesEnum: string
{
	use AssociativeArrayEnumTrait;
	use TranslatableChoicesEnumTrait;

	case ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
	case ROLE_ADMIN       = 'ROLE_ADMIN';
	case ROLE_USER        = 'ROLE_USER';
}
