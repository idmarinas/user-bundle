<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/12/2024, 14:18
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    stof_doctrine_extensions.php
 * @date    27/12/2024
 * @time    14:14
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
	$container->extension('stof_doctrine_extensions', [
		'default_locale'       => '%kernel.default_locale%',
		'translation_fallback' => true,
		'orm'                  => [
			# Activate the extensions you want
			'default' => [
				'translatable'        => false,
				'timestampable'       => true,
				'blameable'           => true,
				'sluggable'           => false,
				'tree'                => false,
				'loggable'            => true,
				'sortable'            => false,
				'softdeleteable'      => true,
				'uploadable'          => false,
				'reference_integrity' => false,
			],
		],
	]);
};
