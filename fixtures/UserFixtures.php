<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/12/2024, 23:06
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
	public const NORMAL_USER = 'normal_user_';
	public const USER_PASS   = 'pass_1234_$%';

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
			'verified'         => true,
			'terms_accepted'   => true,
			'privacy_accepted' => true,
			'password'         => self::USER_PASS,
		];

		// Add SuperAdmin user
		$admin = UserFactory::createOne([
			'display_name' => 'John',
			'email'        => 'john.doe@example.com',
			'roles'        => ['ROLE_SUPER_ADMIN'],
			...$opts,
		]);

		// Add normal user
		$user = UserFactory::createOne([
			'display_name' => 'Jane',
			'email'        => 'jane.doe@example.com',
			...$opts,
		]);

		$this->addReference('user', $user->_real());
		$this->addReference('user_admin', $admin->_real());

		// 200 additional users added
		UserFactory::createMany(200);
		// 50% verified 50% unverified
		$verified = UserFactory::count(['verified' => true]) - 2;
		if (0 != $need = 100 - $verified) {
			if ($need > 0) {
				$more = UserFactory::repository()->findBy(['verified' => false], null, $need, 2);
				foreach ($more as $user) {
					$user->setVerified(true);
					$user->_save();
				}
			}
			else {
				$less = UserFactory::repository()->findBy(['verified' => true], null, abs($need), 2);
				foreach ($less as $user) {
					$user->setVerified(false);
					$user->_save();
				}
			}
		}

		$users = UserFactory::all();
		unset($users[0], $users[1]);
		sort($users);

		foreach ($users as $key => $user) {
			$this->addReference(self::NORMAL_USER . $key, $user->_real());
		}
	}
}
