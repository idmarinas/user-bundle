<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 04/12/2024, 13:05
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserConnectionLogTest.php
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
use Idm\Bundle\User\Entity\AbstractUserConnectionLog;
use Nyholm\BundleTest\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserConnectionLogTest extends KernelTestCase
{
	use FakerTrait;

	protected static function getKernelClass (): string
	{
		return TestKernel::class;
	}

	protected function setUp (): void
	{
		parent::setUp();
		static::bootKernel();
	}

	public function testEntity ()
	{
		$container = static::getContainer();
		$serializer = $container->get('serializer');

		$entity = $this->populateEntity(new UserConnectionLog());
		$this->assertIsObject($entity);

		$array = $serializer->normalize($entity, 'array');
		$this->assertIsArray($array);

		$this->assertIsObject($serializer->denormalize($array, UserConnectionLog::class));
	}
}

class UserConnectionLog extends AbstractUserConnectionLog {}
