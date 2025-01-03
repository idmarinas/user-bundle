<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 30/12/2024, 24:07
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserTest.php
 * @date    04/12/2024
 * @time    12:25
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Entity;

use App\Entity\User\FakeUser;
use App\Entity\User\User;
use DateTime;
use Idm\Bundle\Common\Traits\Tool\FakerTrait;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
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

		/** @var User $entity */
		$entity = $this->populateEntity(new User());
		$this->assertIsObject($entity);

		$this->assertEquals((string)$entity, $entity->getDisplayName());

		$array = $serializer->normalize($entity, 'array');
		$this->assertIsArray($array);

		$this->assertIsObject($serializer->denormalize($array, User::class));

		$entity->setBannedUntil(new DateTime('-0001-11-30'));
		$entity->eraseCredentials();
		$entity->eraseDataForCache();

		$this->assertTrue($entity->isEqualTo($entity));

		$this->assertFalse($entity->isEqualTo(new FakeUser()));

		$fake = clone $entity;
		$fake->setSessionId('fake-session-id');

		$this->assertFalse($entity->isEqualTo($fake));

		$entity->setSessionId($fake->getSessionId());
		$fake->setPassword('fake-password');

		$this->assertFalse($entity->isEqualTo($fake));

		$entity->setPassword($fake->getPassword());
		$fake->setRoles(['ROLE_ADMIN']);

		$this->assertFalse($entity->isEqualTo($fake));

		$entity->setRoles($fake->getRoles());
		$fake->setEmail('fake@email.fk');

		$this->assertFalse($entity->isEqualTo($fake));

		$entity->setEmail($fake->getEmail());
		$fake->setInactive(true);
		$entity->setInactive(false);

		$this->assertFalse($entity->isEqualTo($fake));

		$this->assertIsArray($serializer->normalize($entity, 'array'));
	}
}
