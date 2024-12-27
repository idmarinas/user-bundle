<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "idmarinas" on 27/12/2024, 12:57
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

use DateTime;
use Idm\Bundle\Common\Traits\Tool\FakerTrait;
use Idm\Bundle\User\Entity\ResetPasswordRequest;
use Idm\Bundle\User\Tests\App\Entity\User;
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
