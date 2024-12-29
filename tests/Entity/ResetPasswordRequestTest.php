<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 30/12/2024, 24:07
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

use App\Entity\User\User;
use DateTime;
use Idm\Bundle\Common\Traits\Tool\FakerTrait;
use Idm\Bundle\User\Entity\ResetPasswordRequest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ResetPasswordRequestTest extends KernelTestCase
{
	use FakerTrait;

	public function testResetPasswordRequest ()
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
