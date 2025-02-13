<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 13/02/2025, 20:21
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ResetPasswordRequestTest.php
 * @date    05/12/2024
 * @time    20:49
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Entity;

use App\Entity\User\ResetPasswordRequest;
use DateTime;
use Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Zenstruck\Foundry\Test\Factories;
use function Zenstruck\Foundry\faker;

class ResetPasswordRequestTest extends KernelTestCase
{
	use Factories;

	public function testResetPasswordRequest (): void
	{
		self::bootKernel();
		$container = static::getContainer();
		$serializer = $container->get('serializer');

		$user = UserFactory::new()->withoutPersisting()->create()->_real();
		$entity = new ResetPasswordRequest($user, new DateTime(), faker()->sha1(), faker()->sha1());

		$this->assertIsObject($entity);

		$array = $serializer->normalize($entity, 'array', [
			AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn($object) => $object->getId(),
		]);

		$this->assertIsArray($array);

		$this->assertEquals($entity->getUser(), $user);

		$this->assertEquals($entity->getUser()->getId(), $array['user']['id']);

		$this->assertEquals($entity->getHashedToken(), $array['hashedToken']);
	}
}
