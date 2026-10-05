<?php
/**
 * Copyright 2026-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/10/2026, 19:50
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractResetPasswordRequestFormType.php
 * @date    05/10/2026
 * @time    19:50
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.3.0
 */

namespace Idm\Bundle\User\Model\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractResetPasswordRequestFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('email', EmailType::class, [
				'required'    => true,
				'label'       => false,
				'help'        => 'form.forgot_password.email.help',
				'attr'        => [
					'autocomplete' => 'email',
					'placeholder'  => 'form.forgot_password.email.label',
				],
				'constraints' => [
					new Assert\NotBlank(allowNull: false),
					new Assert\Email(),
				],
			])
			->add('button', SubmitType::class, [
				'label' => 'form.forgot_password.button',
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'translation_domain' => 'IdmUserBundle',
		]);
	}
}
