<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 06/12/2024, 10:52
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    TestKernel.php
 * @date    05/12/2024
 * @time    16:14
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Tests;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Idm\Bundle\User\IdmUserBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use SymfonyCasts\Bundle\VerifyEmail\SymfonyCastsVerifyEmailBundle;

class TestKernel extends Kernel
{
	use MicroKernelTrait;

	public function registerBundles (): iterable
	{
		yield new FrameworkBundle();
		yield new DoctrineBundle();
		yield new SymfonyCastsVerifyEmailBundle();
		yield new IdmUserBundle();
	}

	public function registerContainerConfiguration (LoaderInterface $loader)
	{
		$loader->load(function (ContainerBuilder $container) use ($loader) {
			$container->loadFromExtension('framework', [
				'router'     => [
					'resource' => 'kernel::loadRoutes',
					'type'     => 'service',
					'utf8'     => true,
				],
				'secret'     => 'test',
				'form'       => true,
				'validation' => true,
				'test'       => true,
				'mailer'     => true,
			]);

			$container->loadFromExtension('doctrine', [
				'dbal' => [
					'driver' => 'pdo_sqlite',
					'url'    => 'sqlite:///' . $this->getCacheDir() . '/app.db',
				],
				'orm'  => [
					'enable_lazy_ghost_objects'   => true,
					'auto_generate_proxy_classes' => true,
					'auto_mapping'                => true,
				],
			]);

			$container
				->register('kernel', static::class)
				->setPublic(true)
			;

			$kernelDefinition = $container->getDefinition('kernel');
			$kernelDefinition->addTag('routing.route_loader');
		});
	}

	public function configureRoutes (RoutingConfigurator $routes): void
	{
		$routes->import($this->getConfigDir() . '/routes.php');

		$routes->add('app_home', '/')->methods(['GET']);
	}
}
