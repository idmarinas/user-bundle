<?php
/**
 * Copyright 2026-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/09/2026, 22:25
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserRolesEnumTest.php
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
use Symfony\Component\Translation\TranslatableMessage;

final class UserRolesEnumTest extends TestCase
{
	private static function messages(array $messages): array
	{
		return array_map(
			static fn(TranslatableMessage $message): string => $message->getMessage(),
			$messages
		);
	}

	public function testEnum(): void
	{
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

		$this->assertEquals($translatableChoices, self::messages(UserRolesEnum::toTranslatableChoices()));

		$translatableChoicesPrefix = [
			UserRolesEnum::ROLE_ADMIN->name       => 'prefix.'.strtolower(UserRolesEnum::ROLE_ADMIN->value),
			UserRolesEnum::ROLE_USER->name        => 'prefix.'.strtolower(UserRolesEnum::ROLE_USER->value),
			UserRolesEnum::ROLE_SUPER_ADMIN->name => 'prefix.'.strtolower(UserRolesEnum::ROLE_SUPER_ADMIN->value),
		];

		$this->assertEquals($translatableChoicesPrefix, self::messages(UserRolesEnum::toTranslatableChoices('prefix.')));

		foreach (UserRolesEnum::toTranslatableChoices() as $message) {
			$this->assertInstanceOf(TranslatableMessage::class, $message);
			$this->assertEquals('IdmUserBundle', $message->getDomain());
			$this->assertEmpty($message->getParameters());
		}
	}
}
