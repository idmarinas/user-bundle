<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/01/2025, 11:44
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserRolesEnumTest.php
 * @date    11/01/2025
 * @time    10:46
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Enums;

use Idm\Bundle\User\Enums\UserRolesEnum;
use PHPUnit\Framework\TestCase;

final class UserRolesEnumTest extends TestCase
{
	public function testEnum (): void
	{
		$translatableChoicesPrefix = UserRolesEnum::toTranslatableChoices('prefix.');

		$associative = [
			UserRolesEnum::ROLE_ADMIN->name       => UserRolesEnum::ROLE_ADMIN->value,
			UserRolesEnum::ROLE_USER->name        => UserRolesEnum::ROLE_USER->value,
			UserRolesEnum::ROLE_SUPER_ADMIN->name => UserRolesEnum::ROLE_SUPER_ADMIN->value,
		];

		$this->assertEquals($associative, UserRolesEnum::toAssociativeArray());

		$translatableChoices = [
			UserRolesEnum::ROLE_ADMIN->name       => strtolower(UserRolesEnum::ROLE_ADMIN->value),
			UserRolesEnum::ROLE_USER->name        => strtolower(UserRolesEnum::ROLE_USER->value),
			UserRolesEnum::ROLE_SUPER_ADMIN->name => strtolower(UserRolesEnum::ROLE_SUPER_ADMIN->value),
		];

		$this->assertEquals($translatableChoices, UserRolesEnum::toTranslatableChoices());

		$translatableChoicesPrefix = [
			UserRolesEnum::ROLE_ADMIN->name       => 'prefix.' . strtolower(UserRolesEnum::ROLE_ADMIN->value),
			UserRolesEnum::ROLE_USER->name        => 'prefix.' . strtolower(UserRolesEnum::ROLE_USER->value),
			UserRolesEnum::ROLE_SUPER_ADMIN->name => 'prefix.' . strtolower(UserRolesEnum::ROLE_SUPER_ADMIN->value),
		];

		$this->assertEquals($translatableChoicesPrefix, UserRolesEnum::toTranslatableChoices('prefix.'));
	}
}
