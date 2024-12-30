<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 30/12/2024, 23:56
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserFixtures.php
 * @date    18/12/2024
 * @time    19:59
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Factory\UserFactory;
use ReflectionException;

final class UserFixtures extends Fixture implements FixtureGroupInterface
{
	public const USER_TEST_EMAIL  = 'jonny.doe@example.com';
	public const USER_ADMIN_EMAIL = 'john.doe@example.com';
	public const USER_EMAIL       = 'jane.doe@example.com';
	public const KEY_USER         = 'normal_user_';
	public const USER_PASS        = 'pass_1234_$%';

	public static function getGroups (): array
	{
		return ['test'];
	}

	/**
	 * @throws ReflectionException
	 */
	public function load (ObjectManager $manager): void
	{
		$opts = [
			'banned_until' => null,
			'deleted_at'   => null,
			'password'     => self::KEY_USER,
		];
		// 200 additional users added
		// 50% verified, 50% banned and 50% deleted
		UserFactory::createMany(25, ['verified' => true, 'password' => self::USER_PASS]);
		UserFactory::createMany(25, ['verified' => true, 'banned_until' => null, 'password' => self::USER_PASS]);
		UserFactory::createMany(25, ['verified' => true, 'deleted_at' => null, 'password' => self::USER_PASS]);
		UserFactory::createMany(25, ['verified' => true, ...$opts,]);

		// 50% unverified, 50% banned and 50% deleted
		UserFactory::createMany(25, ['verified' => false, 'password' => self::USER_PASS]);
		UserFactory::createMany(25, ['verified' => false, 'banned_until' => null, 'password' => self::USER_PASS]);
		UserFactory::createMany(25, ['verified' => false, 'deleted_at' => null, 'password' => self::USER_PASS]);
		UserFactory::createMany(25, ['verified' => false, ...$opts]);

		$users = UserFactory::all();

		foreach ($users as $key => $user) {
			$this->addReference(self::NORMAL_USER . $key, $user->_real());
		}

		$opts = [
			'verified'         => true,
			'terms_accepted'   => true,
			'privacy_accepted' => true,
			'banned_until'     => null,
			'deleted_at'       => null,
			'password'         => self::USER_PASS,
		];

		// Add SuperAdmin user
		$admin = UserFactory::createOne([
			'display_name' => 'John',
			'email'        => self::USER_ADMIN_EMAIL,
			'roles'        => ['ROLE_SUPER_ADMIN'],
			...$opts,
		]);

		// Add normal user
		$user = UserFactory::createOne([
			'display_name' => 'Jane',
			'email'        => self::USER_EMAIL,
			...$opts,
		]);

		$this->addReference('user', $user->_real());
		$this->addReference('user_admin', $admin->_real());
	}
}
