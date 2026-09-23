<?php
/**
 * Copyright 2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/09/2026, 19:57
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserPremiumTest.php
 * @date    04/12/2024
 * @time    12:25
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\DataFixtures\Entity;

use App\Entity\User\Premium;
use App\Entity\User\User;
use Idm\Bundle\User\Tests\Factory\UserFactory;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Zenstruck\Foundry\Test\Factories;

class UserPremiumTest extends KernelTestCase
{
	use Factories;

	/**
	 * @throws ReflectionException
	 */
	public function testEntity(): void
	{
		static::bootKernel();
		$container = static::getContainer();
		$serializer = $container->get('serializer');

		/** @var User $user */
		$user = UserFactory::new()->withoutPersisting()->create();
		$userFake = clone $user;
		$userFake->setEmail('fake@user.fk');

		$premium = new Premium();
		$premium->setUser($user);

		$user->setPremium($premium);
		$userFake->setPremium($premium);

		$this->assertIsObject($premium);

		$array = $serializer->normalize($premium, 'array', [
			AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn($object) => $object->getUser(),
		]);
		$this->assertIsArray($array);
	}
}
