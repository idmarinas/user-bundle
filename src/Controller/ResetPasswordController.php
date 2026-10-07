<?php
/**
 * Copyright 2026-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 07/10/2026, 12:38
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ResetPasswordController.php
 * @date    07/10/2026
 * @time    12:19
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.3.0
 */

namespace Idm\Bundle\User\Controller;

use Idm\Bundle\User\Form\ResetPasswordFormType;
use Idm\Bundle\User\Form\ResetPasswordRequestFormType;
use Idm\Bundle\User\Model\Controller\AbstractResetPasswordController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reset-password')]
final class ResetPasswordController extends AbstractResetPasswordController
{
	protected function getResetPasswordRequestForm(?object $data = null, array $options = []): FormInterface
	{
		return $this->createForm(ResetPasswordRequestFormType::class, $data, $options);
	}

	protected function getResetPasswordForm(?object $data = null, array $options = []): FormInterface
	{
		return $this->createForm(ResetPasswordFormType::class, $data, $options);
	}
}
