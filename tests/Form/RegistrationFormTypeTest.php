<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 30/12/2024, 24:07
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    RegistrationFormTypeTest.php
 * @date    02/12/2024
 * @time    21:35
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Form;

use App\Entity\User\User;
use Idm\Bundle\Common\Traits\Tool\FakerTrait;
use Idm\Bundle\User\Form\RegistrationFormType;
use Symfony\Component\Form\Test\Traits\ValidatorExtensionTrait;
use Symfony\Component\Form\Test\TypeTestCase;

class RegistrationFormTypeTest extends TypeTestCase
{
	use FakerTrait;
	use ValidatorExtensionTrait;

	public function testSubmitValidData ()
	{
		$password = $this->faker()->password();
		$formData = [
			'email'                          => $this->faker()->email(),
			'plainPassword[password]'        => $password,
			'plainPassword[password_repeat]' => $password,
			'termsAccepted'                  => true,
			'privacyAccepted'                => true,
		];

		$entity = new User();
		$form = $this->factory->create(RegistrationFormType::class, $entity);

		$expected = (clone $entity)
			->setEmail($formData['email'])
			->setTermsAccepted($formData['termsAccepted'])
			->setPrivacyAccepted($formData['privacyAccepted'])
		;

		$form->submit($formData);

		$this->assertTrue($form->isSynchronized());
		$this->assertEquals($expected, $form->getData());
	}
}
