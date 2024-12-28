<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 28/12/2024, 12:10
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

namespace Idm\Bundle\User\Tests\App;

use DAMA\DoctrineTestBundle\DAMADoctrineTestBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Exception;
use Idm\Bundle\User\IdmUserBundle;
use Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle;
use Symfony\Bundle\FrameworkBundle\Controller\TemplateController;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use SymfonyCasts\Bundle\ResetPassword\SymfonyCastsResetPasswordBundle;
use SymfonyCasts\Bundle\VerifyEmail\SymfonyCastsVerifyEmailBundle;
use Zenstruck\Foundry\ZenstruckFoundryBundle;

final class Kernel extends BaseKernel
{
	use MicroKernelTrait;

	public function registerBundles (): iterable
	{
		yield from parent::getBundles();

		yield new FrameworkBundle();
		yield new DoctrineBundle();
		yield new SymfonyCastsVerifyEmailBundle();
		yield new SymfonyCastsResetPasswordBundle();
		yield new IdmUserBundle();
		yield new TwigBundle();
		yield new SecurityBundle();
		yield new StofDoctrineExtensionsBundle();

		// Dev-Test Bundles
		yield new DoctrineFixturesBundle();
		yield new DAMADoctrineTestBundle();
		yield new ZenstruckFoundryBundle();
	}

	/**
	 * @throws Exception
	 */
	public function registerContainerConfiguration (LoaderInterface $loader): void
	{
		$loader->load($this->getProjectDir() . '/tests/config/framework.php');
		$loader->load($this->getProjectDir() . '/tests/config/framework/mailer.php');
		$loader->load($this->getProjectDir() . '/tests/config/framework/router.php');
		$loader->load($this->getProjectDir() . '/tests/config/framework/session.php');
		$loader->load($this->getProjectDir() . '/tests/config/framework/validation.php');
		$loader->load($this->getProjectDir() . '/tests/config/doctrine.php');
		$loader->load($this->getProjectDir() . '/tests/config/security.php');
		$loader->load($this->getProjectDir() . '/tests/config/stof_doctrine_extensions.php');

		$loader->load($this->getProjectDir() . '/tests/config/service.php');
		$loader->load($this->getConfigDir() . '/factories.php');
		$loader->load($this->getConfigDir() . '/fixtures.php');

		$loader->load(function (ContainerBuilder $container) {
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
}
