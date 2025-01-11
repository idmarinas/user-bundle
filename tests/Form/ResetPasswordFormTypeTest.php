<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/01/2025, 10:59
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ResetPasswordFormTypeTest.php
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
use Idm\Bundle\User\Form\ResetPasswordFormType;
use Symfony\Component\Form\Test\Traits\ValidatorExtensionTrait;
use Symfony\Component\Form\Test\TypeTestCase;

class ResetPasswordFormTypeTest extends TypeTestCase
{
	use FakerTrait;
	use ValidatorExtensionTrait;

	public function testResetPasswordForm (): void
	{
		$formData = [
			'plainPassword' => [
				'first'  => $this->faker()->password(),
				'second' => $this->faker()->password(),
			],
		];

		$form = $this->factory->create(ResetPasswordFormType::class, $formData);

		$form->submit($formData);

		$this->assertTrue($form->isSynchronized());
		$this->assertTrue($form->isValid());
		$this->assertEquals($formData['plainPassword']['first'], $form->get('plainPassword')->get('first')->getData());
		$this->assertEquals($formData['plainPassword']['second'], $form->get('plainPassword')->get('second')->getData());
	}
}
