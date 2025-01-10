<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 10/01/2025, 14:58
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    TranslatableChoicesEnumTrait.php
 * @date    10/01/2025
 * @time    14:05
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
trait TranslatableChoicesEnumTrait
{
	public static function toTranslatableChoices (string $prefix = ''): array
	{
		$cases = [];

		foreach (self::cases() as $case) {
			$cases[$case->name] = $prefix . strtolower($case->value);
		}

		return $cases;
	}
}
