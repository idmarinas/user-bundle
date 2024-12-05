<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/12/2024, 17:29
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
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Tests\Entity;

use Idm\Bundle\Common\Traits\Tool\FakerTrait;
use Idm\Bundle\User\Entity\AbstractUser;
use Idm\Bundle\User\Entity\AbstractUserPremium;
use Idm\Bundle\User\Entity\Traits\UserPremiumTrait;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class UserPremiumTest extends KernelTestCase
{
	use FakerTrait;

	/**
	 * @throws ReflectionException
	 */
	public function testEntity ()
	{
		static::bootKernel();
		$container = static::getContainer();
		$serializer = $container->get('serializer');

		/** @var UserFull $user */
		$user = $this->populateEntity(new UserFull());
		$userFake = clone $user;
		$userFake->setEmail('fake@user.fk');

		$premium = new UserPremium();
		$premium->setUser($user);

		$user->setPremium($premium);
		$userFake->setPremium($premium);

		$entity = $this->populateEntity($premium);
		$this->assertIsObject($entity);

		$array = $serializer->normalize($entity, 'array', [
			AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn($object) => $object->getUser(),
		]);
		$this->assertIsArray($array);
	}
}

class UserPremium extends AbstractUserPremium {}

class UserFull extends AbstractUser
{
	use UserPremiumTrait;
}
