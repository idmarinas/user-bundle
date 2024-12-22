<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 22/12/2024, 22:52
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    RegistrationFormType.php
 * @date    02/12/2024
 * @time    16:50
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Form;

use Idm\Bundle\User\Validator\Constraint\PasswordRequirements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

final class RegistrationFormType extends AbstractType
{
	public function buildForm (FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('email', EmailType::class, [
				'label' => false,
				'attr'  => [
					'placeholder' => 'form.register.email',
				],
			])
			->add('plainPassword', RepeatedType::class, [
				'type'            => PasswordType::class,
				// instead of being set onto the object directly,
				// this is read and encoded in the controller
				'mapped'          => false,
				'invalid_message' => 'password.not_match',
				'options'         => [
					'attr' => [
						'autocomplete' => 'new-password',
					],
				],
				'first_name'      => 'password',
				'second_name'     => 'password_repeat',
				'first_options'   => [
					'label' => false,
					'attr'  => ['placeholder' => 'form.register.password'],
				],
				'second_options'  => [
					'label' => false,
					'attr'  => ['placeholder' => 'form.register.repeat_password'],
				],
				'constraints'     => [
					new PasswordRequirements(),
				],
			])
			->add('termsAccepted', CheckboxType::class, [
				'label'       => 'form.register.agree_terms',
				'constraints' => [
					new Assert\IsTrue(['message' => 'idm_user_bundle.agree_terms']),
				],
			])
			->add('privacyAccepted', CheckboxType::class, [
				'label'       => 'form.register.agree_privacy',
				'constraints' => [
					new Assert\IsTrue(['message' => 'idm_user_bundle.agree_privacy']),
				],
			])
			->add('button', SubmitType::class, [
				'label' => 'form.register.button',
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
