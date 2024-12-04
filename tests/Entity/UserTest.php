<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 04/12/2024, 13:02
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
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Tests\Entity;

use Idm\Bundle\Common\Traits\Tool\FakerTrait;
use Idm\Bundle\User\Entity\AbstractUser;
use Nyholm\BundleTest\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
	use FakerTrait;

	public function testEntity ()
	{
		$container = static::getContainer();
		$serializer = $container->get('serializer');

		$entity = $this->populateEntity(new User());
		$this->assertIsObject($entity);

		$this->assertEquals((string)$entity, $entity->getDisplayName());

		$array = $serializer->normalize($entity, 'array');
		$this->assertIsArray($array);

		$this->assertIsObject($serializer->denormalize($array, User::class));
	}

	protected function setUp (): void
	{
		parent::setUp();
		static::bootKernel();
	}

	protected static function getKernelClass (): string
	{
		return TestKernel::class;
	}
}

class User extends AbstractUser {}
