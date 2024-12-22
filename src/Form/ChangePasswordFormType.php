<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 22/12/2024, 22:52
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ChangePasswordFormType.php
 * @date    02/12/2024
 * @time    17:48
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
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

final class ChangePasswordFormType extends AbstractType
{
	public function buildForm (FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('currentPassword', PasswordType::class, [
				'mapped'      => false,
				'attr'        => [
					'placeholder'  => 'form.change_password.current_password',
					'autocomplete' => 'current-password',
				],
				'label'       => false,
				'constraints' => [
					new SecurityAssert\UserPassword(),
				],
			])
			->add('plainPassword', RepeatedType::class, [
				// Instead of being set onto the object directly,
				// this is read and encoded in the controller
				'mapped'          => false,
				'type'            => PasswordType::class,
				'options'         => [
					'attr' => [
						'autocomplete' => 'new-password',
					],
				],
				'first_options'   => [
					'attr'  => ['autocomplete' => 'new-password', 'placeholder' => 'form.change_password.new'],
					'label' => false,
				],
				'second_options'  => [
					'attr'  => ['autocomplete' => 'new-password', 'placeholder' => 'form.change_password.repeat'],
					'label' => false,
				],
				'constraints'     => [
					new PasswordRequirements(),
				],
				'invalid_message' => 'idm_user_bundle.password.not_match',
			])
			->add('button', SubmitType::class, [
				'label' => 'form.change_password.button',
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
