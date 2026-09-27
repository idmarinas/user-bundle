<?php
/**
 * Copyright 2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/09/2026, 20:08
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserConnectionsTest.php
 * @date    27/09/2026
 * @time    20:11
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.2.0
 */

declare(strict_types=1);

/**
 * Copyright 2026-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 24/09/2026, 18:10
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
use Idm\Bundle\User\Tests\Factory\ConnectionsFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

final class UserConnectionsTest extends KernelTestCase
{
	public function testEntity(): void
	{
		static::bootKernel();
		$container = static::getContainer();
		$serializer = $container->get('serializer');

		$entity = ConnectionsFactory::new()->create();
		$this->assertIsObject($entity);

		$array = $serializer->normalize($entity, 'array', [
			AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn($object) => $object->getId(),
		]);
		$this->assertIsArray($array);

		$this->assertIsObject($serializer->denormalize($array, Connections::class));
	}
}
