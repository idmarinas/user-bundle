<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 2/12/24, 17:58
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractResetPasswordRequestFormType.php
 * @date    02/12/2024
 * @time    17:58
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractResetPasswordRequestFormType extends AbstractType
{
	public function buildForm (FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('email', EmailType::class, [
				'required'    => true,
				'label'       => false,
				'attr'        => [
					'autocomplete' => 'email',
					'placeholder'  => 'form.forgot_password.email',
				],
				'constraints' => [
					new Assert\Email(),
				],
			])
			->add('button', SubmitType::class, [
				'label' => 'form.forgot_password.button',
			])
		;
	}

	public function configureOptions (OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'translation_domain' => 'IdmUserBundle',
		]);
	}
}