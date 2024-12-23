<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 22/12/2024, 22:51
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ResetPasswordRequestFormTypeTest.php
 * @date    02/12/2024
 * @time    21:35
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Form;

use Idm\Bundle\Common\Traits\Tool\FakerTrait;
use Idm\Bundle\User\Form\ResetPasswordRequestFormType;
use Symfony\Component\Form\Test\Traits\ValidatorExtensionTrait;
use Symfony\Component\Form\Test\TypeTestCase;

class ResetPasswordRequestFormTypeTest extends TypeTestCase
{
	use FakerTrait;
	use ValidatorExtensionTrait;

	public function testSubmitValidData ()
	{
		$formData = [
			'email' => $this->faker()->email(),
		];

		$form = $this->factory->create(ResetPasswordRequestFormType::class);

		$form->submit($formData);

		$this->assertTrue($form->isSynchronized());
		$this->assertTrue($form->isValid());

		$this->assertEquals($formData['email'], $form->get('email')->getData());
	}
}
