<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/02/2025, 23:08
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    RegistrationController.php
 * @date    11/02/2025
 * @time    22:43
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace App\Controller;

use App\Form\RegistrationFormType;
use Idm\Bundle\User\Model\Controller\AbstractRegistrationController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route(path: '/registration', name: 'registration_')]
class RegistrationController extends AbstractRegistrationController
{
    protected function getRegistrationForm (object $data, array $options = []): FormInterface
    {
        return $this->createForm(RegistrationFormType::class, $data, $options);
    }
}
