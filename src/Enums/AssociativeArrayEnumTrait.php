<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 10/01/2025, 14:19
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AssociativeArrayEnumTrait.php
 * @date    10/01/2025
 * @time    13:57
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Enums;

/**
 * @method static cases()
 */
trait AssociativeArrayEnumTrait
{

	public static function toAssociativeArray (): array
	{
		return array_column(self::cases(), 'value', 'name');
	}
}
