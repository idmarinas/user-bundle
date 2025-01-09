<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 09/01/2025, 19:23
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    reset_password.php
 * @date    09/01/2025
 * @time    19:23
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Repository\User\ResetPasswordRequestRepository;

return static function (ContainerConfigurator $container) {
	$container->extension('symfonycasts_reset_password', [
		'request_password_repository' => ResetPasswordRequestRepository::class,
	]);
};
