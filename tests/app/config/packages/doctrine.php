<?php
/**
 * Copyright 2026-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/09/2026, 21:45
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
use Idm\Bundle\User\IdmUserBundle;
use Idm\Bundle\User\Model\Entity\AbstractConnections;
use Idm\Bundle\User\Model\Entity\AbstractPremium;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;
use function Symfony\Component\String\u;

return static function (ContainerConfigurator $container, ContainerBuilder $builder) {
	$getDatabaseCache = function (string $projectDir, string $env): string {
		$dir = $projectDir.'/var/cache/database';

		if ($env !== 'dev') {
			$env = 'test';
		}

		$filesystem = new Filesystem();

		if (!$filesystem->exists($dir)) {
			$filesystem->mkdir($dir);
		}

		$dbName = (new ReflectionClass(IdmUserBundle::class))->getShortName();
		$dbName = u($dbName)->snake()->toString();

		return sprintf('sqlite:///%s/%s_%s.sqlite', $dir, $dbName, $env);
	};

	$container->extension('doctrine', [
		'dbal' => [
			'driver' => 'pdo_sqlite',
			'url'    => $getDatabaseCache($builder->getParameter('kernel.project_dir'), $container->env()),
			'types'  => [
				'array' => 'Doctrine\DBAL\Types\JsonType',
			],
		],
		'orm'  => [
			'auto_mapping'            => false,
			'controller_resolver'     => [
				'auto_mapping' => false,
			],
			'mappings'                => [
				'Tests' => [
					'is_bundle' => false,
					'mapping'   => true,
					'type'      => 'attribute',
					'dir'       => dirname(__DIR__, 2).'/src/Entity',
					'prefix'    => 'App\Entity',
				],
			],
			'resolve_target_entities' => [
				AbstractUser::class        => User::class,
				AbstractPremium::class     => Premium::class,
				AbstractConnections::class => Connections::class,
			],
		],
	]);
};
