<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/01/2025, 10:56
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    doctrine.php
 * @date    27/12/2024
 * @time    14:14
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Entity\User\Connections;
use App\Entity\User\Premium;
use App\Entity\User\User;
use Idm\Bundle\User\Model\Entity\AbstractConnections;
use Idm\Bundle\User\Model\Entity\AbstractPremium;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Symfony\Component\Filesystem\Filesystem;

return static function (ContainerConfigurator $container): void {
	$getDatabaseCache = function (): string {
		$dir = dirname(__DIR__, 3) . '/var/cache/database';

		$filesystem = new Filesystem();

		if (!$filesystem->exists($dir)) {
			$filesystem->mkdir($dir);
		}

		return $dir;
	};

	$container->extension('doctrine', [
		'dbal' => [
			'driver'         => 'pdo_sqlite',
			'url'            => sprintf('sqlite:///%s/idm_user_%s.sqlite', $getDatabaseCache(), $container->env()),
			'use_savepoints' => true,
		],
		'orm'  => [
			'enable_lazy_ghost_objects'   => true,
			'auto_generate_proxy_classes' => true,
			'auto_mapping'                => false,
			'controller_resolver'         => [
				'auto_mapping' => false,
			],
			'mappings'                    => [
				'Tests' => [
					'is_bundle' => false,
					'mapping'   => true,
					'type'      => 'attribute',
					'dir'       => dirname(__DIR__, 2) . '/src/Entity',
					'prefix'    => 'App\Entity',
				],
			],
			'resolve_target_entities'     => [
				AbstractUser::class        => User::class,
				AbstractPremium::class     => Premium::class,
				AbstractConnections::class => Connections::class,
			],
		],
	]);
};
