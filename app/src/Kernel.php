<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 30/12/2024, 17:27
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    Kernel.php
 * @date    05/12/2024
 * @time    16:14
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace App;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\TemplateController;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
	use MicroKernelTrait;

	public function configureRoutes (RoutingConfigurator $routes): void
	{
		$routes->import($this->getConfigDir() . '/routes.php');
		$routes->import('security.route_loader.logout', 'service')->methods(['GET']);

		$routes
			->add('app_home', '/')
			->methods(['GET'])
			->controller(TemplateController::class)
			->defaults([
				'template' => '@IdmUser/base.html.twig',
			])
		;
	}

	/**
	 * @throws Exception
	 */
	protected function build (ContainerBuilder $container): void
	{
		$loader = $this->getContainerLoader($container);

		// Load config for Test App
		$loader->load($this->getTestPackagesConfigDir() . '/framework.php');
		$loader->load($this->getTestPackagesConfigDir() . '/framework/mailer.php');
		$loader->load($this->getTestPackagesConfigDir() . '/framework/router.php');
		$loader->load($this->getTestPackagesConfigDir() . '/framework/session.php');
		$loader->load($this->getTestPackagesConfigDir() . '/framework/validation.php');
		$loader->load($this->getTestPackagesConfigDir() . '/doctrine.php');
		$loader->load($this->getTestPackagesConfigDir() . '/security.php');
		$loader->load($this->getTestPackagesConfigDir() . '/stof_doctrine_extensions.php');

		// Load service of Bundle
		$loader->load($this->getTestConfigDir() . '/service.php');

		// Load Fixtures and Factories of Bundle
		$loader->load($this->getConfigDir() . '/factories.php');
		$loader->load($this->getConfigDir() . '/fixtures.php');
	}

	private function getBundlesPath (): string
	{
		return $this->getTestConfigDir() . '/bundles.php';
	}

	private function getTestConfigDir (): string
	{
		return $this->getProjectDir() . '/app/config';
	}

	private function getTestPackagesConfigDir (): string
	{
		return $this->getTestPackagesConfigDir() . '/packages';
	}
}
