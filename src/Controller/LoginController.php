<?php
/**
 * Copyright 2026-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 07/10/2026, 12:21
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    LoginController.php
 * @date    06/10/2026
 * @time    18:35
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.3.0
 */

namespace Idm\Bundle\User\Controller;

use Idm\Bundle\User\Model\Controller\AbstractLoginController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/login', name: 'login_')]
final class LoginController extends AbstractLoginController {}
