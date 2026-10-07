<?php
/**
 * Copyright 2026-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 07/10/2026, 13:09
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    RegistrationController.php
 * @date    07/10/2026
 * @time    12:19
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.3.0
 */

namespace Idm\Bundle\User\Controller;

use App\Form\RegistrationFormType;
use Idm\Bundle\User\Model\Controller\AbstractRegistrationController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/registration', name: 'registration_')]
final class RegistrationController extends AbstractRegistrationController
{
	protected function getRegistrationForm(?object $data, array $options = []): FormInterface
	{
		return $this->createForm(RegistrationFormType::class, $data, $options);
	}
}
