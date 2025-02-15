<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 15/02/2025, 11:53
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ConnectionsFactory.php
 * @date    13/02/2025
 * @time    19:08
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Factory;

use App\Entity\User\Connections;
use DateTimeImmutable;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Connections>
 */
final class ConnectionsFactory extends PersistentProxyObjectFactory
{
	public static function class (): string
	{
		return Connections::class;
	}

	/**
	 * @see  https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
	 *
	 * @todo add your default values here
	 */
	protected function defaults (): array|callable
	{
		return [
			'clientName'     => self::faker()->text(50),
			'clientType'     => self::faker()->text(50),
			'clientVersion'  => self::faker()->text(50),
			'connectionDate' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
			'deviceName'     => self::faker()->text(50),
			'osName'         => self::faker()->text(50),
			'osVersion'      => self::faker()->text(50),
			'user'           => UserFactory::new(),
			'userAgent'      => self::faker()->userAgent(),
		];
	}

	/**
	 * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
	 */
	protected function initialize (): static
	{
		return $this// ->afterInstantiate(function(Connections $connections): void {})
			;
	}
}
