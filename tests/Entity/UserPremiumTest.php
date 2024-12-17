<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/12/2024, 11:54
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

namespace Idm\Bundle\User\Tests\Entity;

use Idm\Bundle\Common\Traits\Tool\FakerTrait;
use Idm\Bundle\User\Tests\Fixtures\Entity\User;
use Idm\Bundle\User\Tests\Fixtures\Entity\UserPremium;
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

		/** @var User $user */
		$user = $this->populateEntity(new User());
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
