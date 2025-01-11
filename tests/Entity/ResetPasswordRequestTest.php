<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/01/2025, 10:59
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
use App\Entity\User\User;
use DateTime;
use Idm\Bundle\Common\Traits\Tool\FakerTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ResetPasswordRequestTest extends KernelTestCase
{
	use FakerTrait;

	public function testResetPasswordRequest (): void
	{
		self::bootKernel();
		$container = static::getContainer();
		$serializer = $container->get('serializer');

		/** @var User $user */
		$user = $this->populateEntity(new User());
		$entity = new ResetPasswordRequest($user, new DateTime(), $this->faker()->sha1(), $this->faker()->sha1());
		$entity = $this->populateEntity($entity);

		$this->assertIsObject($entity);

		$this->assertIsArray($serializer->normalize($entity, 'array'));
	}
}
