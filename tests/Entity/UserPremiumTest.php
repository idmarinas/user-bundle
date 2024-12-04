<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 04/12/2024, 14:36
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
use Idm\Bundle\User\Entity\AbstractUserPremium;
use Nyholm\BundleTest\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserPremiumTest extends KernelTestCase
{
	use FakerTrait;

	public function testEntity ()
	{
		$container = static::getContainer();
		$serializer = $container->get('serializer');

		/** @var User $user */
		$user = $this->populateEntity(new User());

		$premium = new UserPremium();
		$premium->setUser($user);

		$entity = $this->populateEntity($premium);
		$this->assertIsObject($entity);

		$array = $serializer->normalize($entity, 'array');
		$this->assertIsArray($array);
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

class UserPremium extends AbstractUserPremium {}
