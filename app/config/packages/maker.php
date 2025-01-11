<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/01/2025, 10:56
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    maker.php
 * @date    09/01/2025
 * @time    21:47
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Idm\Bundle\User\IdmUserBundle;
use ReflectionClass;

return static function (ContainerConfigurator $container): void {
	$container->extension('maker', [
		'root_namespace' => (new ReflectionClass(IdmUserBundle::class))->getNamespaceName(),
	]);
};
