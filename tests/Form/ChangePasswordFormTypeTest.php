<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 3/12/24, 14:07
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ChangePasswordFormTypeTest.php
 * @date    02/12/2024
 * @time    21:34
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Tests\Form;

use Idm\Bundle\Common\Traits\Tool\FakerTrait;
use Idm\Bundle\User\Form\AbstractChangePasswordFormType;
use Symfony\Component\Form\Test\Traits\ValidatorExtensionTrait;
use Symfony\Component\Form\Test\TypeTestCase;

class ChangePasswordFormTypeTest extends TypeTestCase
{
	use FakerTrait;
	use ValidatorExtensionTrait;

	public function testSubmitValidData ()
	{
		$formData = [
			'currentPassword' => $this->faker()->password(),
			'plainPassword'   => [
				'first'  => $this->faker()->password(),
				'second' => $this->faker()->password(),
			],
		];

		$form = $this->factory->create(ChangePasswordFormType::class);

		$form->submit($formData);

		$this->assertTrue($form->isValid());
		$this->assertTrue($form->isSynchronized());
		$this->assertEquals($formData['currentPassword'], $form->get('currentPassword')->getData());
		$this->assertEquals($formData['plainPassword']['first'], $form->get('plainPassword')->get('first')->getData());
		$this->assertEquals($formData['plainPassword']['second'], $form->get('plainPassword')->get('second')->getData());
	}
}

class ChangePasswordFormType extends AbstractChangePasswordFormType {}