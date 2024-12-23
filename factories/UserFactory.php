<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/12/2024, 21:14
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserFactory.php
 * @date    19/12/2024
 * @time    18:58
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Factory;

use Idm\Bundle\User\Tests\Fixtures\Entity\User;
use Idm\Bundle\User\Tests\Fixtures\Entity\UserPremium;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

final class UserFactory extends PersistentProxyObjectFactory
{
	public function __construct (private readonly UserPasswordHasherInterface $hasher)
	{
		parent::__construct();
	}

	/**
	 * @inheritDoc
	 */
	public static function class (): string
	{
		return User::class;
	}

	protected function defaults (): array|callable
	{
		$createdAt = self::faker()->dateTime('-1 year');
		$updatedAt = self::faker()->dateTimeBetween($createdAt);

		return [
			'email'                 => self::faker()->unique()->email(),
			'premium'               => new UserPremium(),
			'display_name'          => self::faker()->unique()->userName(),
			'session_id'            => self::faker()->sha1(),
			'idmarinas_id'          => self::faker()->randomNumber(9),
			'idmarinas_token'       => self::faker()->unique()->sha1(),
			'idmarinas_profile_url' => self::faker()->url(),
			'created_from_ip'       => self::faker()->ipv4(),
			'updated_from_ip'       => self::faker()->ipv4(),
			'last_connection'       => self::faker()->dateTimeBetween($createdAt, $updatedAt),
			'created_at'            => $createdAt,
			'updated_at'            => $updatedAt,
			'privacy_accepted'      => self::faker()->boolean(),
			'terms_accepted'        => self::faker()->boolean(),
			'verified'              => self::faker()->boolean(),
		];
	}

	protected function initialize (): static
	{
		return parent::initialize()
			->afterInstantiate(function (User $user) {
				$user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));
			})
		;
	}
}
