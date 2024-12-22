<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 22/12/2024, 22:36
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ResetPasswordFormType.php
 * @date    02/12/2024
 * @time    17:54
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Form;

use Idm\Bundle\User\Validator\Constraint\PasswordRequirements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ResetPasswordFormType extends AbstractType
{
	public function buildForm (FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('plainPassword', RepeatedType::class, [
				'type'            => PasswordType::class,
				'first_options'   => [
					'attr'  => ['autocomplete' => 'new-password', 'placeholder' => 'form.reset_password.new'],
					'label' => 'form.reset_password.new',
				],
				'second_options'  => [
					'attr'  => ['autocomplete' => 'new-password', 'placeholder' => 'form.reset_password.repeat'],
					'label' => 'form.reset_password.repeat',
				],
				'constraints'     => [
					new PasswordRequirements(),
				],
				'invalid_message' => 'idm_user_bundle.password.not_match',
				// Instead of being set onto the object directly,
				// this is read and encoded in the controller
				'mapped'          => false,
			])
			->add('button', SubmitType::class, [
				'label' => 'form.reset_password.button',
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
