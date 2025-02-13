<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/02/2025, 23:21
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ResetPasswordController.php
 * @date    11/02/2025
 * @time    22:43
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace App\Controller;

use Idm\Bundle\User\Form\ResetPasswordFormType;
use Idm\Bundle\User\Form\ResetPasswordRequestFormType;
use Idm\Bundle\User\Model\Controller\AbstractResetPasswordController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/reset-password')]
class ResetPasswordController extends AbstractResetPasswordController
{
	protected function getResetPasswordRequestForm (object $data = null, array $options = []): FormInterface
	{
		return $this->createForm(ResetPasswordRequestFormType::class, $data, $options);
	}

	protected function getResetPasswordForm (object $data = null, array $options = []): FormInterface
	{
		return $this->createForm(ResetPasswordFormType::class, $data, $options);
	}
}
