<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 13/02/2025, 21:07
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
use Factory\ConnectionsFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Zenstruck\Foundry\Test\Factories;

class UserConnectionsTest extends KernelTestCase
{
	use Factories;

	public function testEntity (): void
	{
		static::bootKernel();
		$container = static::getContainer();
		$serializer = $container->get('serializer');

		$entity = ConnectionsFactory::new()->create()->_real();
		$this->assertIsObject($entity);

		$array = $serializer->normalize($entity, 'array', [
			AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn($object) => $object->getId(),
		]);
		$this->assertIsArray($array);

		$this->assertIsObject($serializer->denormalize($array, Connections::class));
	}
}
