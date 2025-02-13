<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/02/2025, 23:41
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserConnectionsTest.php
 * @date    04/12/2024
 * @time    12:25
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Entity;

use App\Entity\User\Connections;
use Idm\Bundle\Common\Traits\Tool\FakerTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserConnectionsTest extends KernelTestCase
{
	use FakerTrait;

	public function testEntity (): void
	{
		static::bootKernel();
		$container = static::getContainer();
		$serializer = $container->get('serializer');

		$entity = $this->populateEntity(new Connections());
		$this->assertIsObject($entity);

		$array = $serializer->normalize($entity, 'array');
		$this->assertIsArray($array);

		$this->assertIsObject($serializer->denormalize($array, Connections::class));
	}
}
