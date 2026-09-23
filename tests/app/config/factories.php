<?php
/**
 * Copyright $originalComment.match("Copyright (\d+)", 1, "-",$today.year)2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/09/2026, 19:45
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    factories.php
 * @date    17/12/2024
 * @time    21:41
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

use Idm\Bundle\User\IdmUserBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container, ContainerBuilder $builder) {
	$namespace = (new ReflectionClass(IdmUserBundle::class))->getNamespaceName();

	// @formatter:off
	$container
		->services()
			->load($namespace.'\\Tests\\Factory\\', $builder->getParameter('kernel.project_dir'). '/tests/Factory')
			->public()
			->autowire()
			->autoconfigure()
	;
	// @formatter:on
};
