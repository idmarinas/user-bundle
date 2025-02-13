<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/02/2025, 22:48
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    LoginController.php
 * @date    11/02/2025
 * @time    22:42
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace App\Controller;

use Idm\Bundle\User\Model\Controller\AbstractLoginController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/login', name: 'login_')]
class LoginController extends AbstractLoginController {}
