<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/12/2024, 20:54
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
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests;

use DAMA\DoctrineTestBundle\DAMADoctrineTestBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Exception;
use Idm\Bundle\User\IdmUserBundle;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Idm\Bundle\User\Model\Entity\AbstractUserConnectionLog;
use Idm\Bundle\User\Model\Entity\AbstractUserPremium;
use Idm\Bundle\User\Tests\Fixtures\Entity\User;
use Idm\Bundle\User\Tests\Fixtures\Entity\UserConnectionLog;
use Idm\Bundle\User\Tests\Fixtures\Entity\UserPremium;
use Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use SymfonyCasts\Bundle\ResetPassword\SymfonyCastsResetPasswordBundle;
use SymfonyCasts\Bundle\VerifyEmail\SymfonyCastsVerifyEmailBundle;
use Zenstruck\Foundry\ZenstruckFoundryBundle;

class TestKernel extends Kernel
{
	use MicroKernelTrait;

	public function registerBundles (): iterable
	{
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
		$loader->load(function (ContainerBuilder $container) use ($loader) {
			$container->loadFromExtension('framework', [
				'test'                  => true,
				'http_method_override'  => false,
				'handle_all_throwables' => true,
				'php_errors'            => [
					'log' => true,
				],
				'router'                => [
					'resource' => 'kernel::loadRoutes',
					'type'     => 'service',
					'utf8'     => true,
				],
				'secret'                => 'test',
				'form'                  => true,
				'validation'            => [
					'email_validation_mode'    => 'html5',
					'not_compromised_password' => false,
				],
				'mailer'                => [
					'dsn' => 'null://null',
				],
				'session'               => [
					'handler_id'         => null,
					'cookie_secure'      => true,
					'cookie_samesite'    => 'lax',
					'storage_factory_id' => 'session.storage.factory.mock_file',
				],
			]);

			$container->loadFromExtension('doctrine', [
				'dbal' => [
					'driver'         => 'pdo_sqlite',
					'url'            => sprintf('sqlite:///%s/idm_user_%s.sqlite', $this->getDatabaseCache(), $this->environment),
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
						'IdmUserTestBundle' => [
							'mapping' => true,
							'type'    => 'attribute',
							'dir'     => __DIR__ . '/Fixtures/Entity',
							'prefix'  => 'Idm\Bundle\User\Tests\Fixtures\Entity',
						],
						'IdmUserBundle'     => [
							'mapping' => true,
							'type'    => 'attribute',
							'dir'     => dirname(__DIR__) . '/src/Entity',
							'prefix'  => 'Idm\Bundle\User\Entity',
						],
					],
					'resolve_target_entities'     => [
						AbstractUser::class              => User::class,
						AbstractUserPremium::class       => UserPremium::class,
						AbstractUserConnectionLog::class => UserConnectionLog::class,
					],
				],
			]);

			$securityConfig = [];
			if (Kernel::VERSION_ID < 60000) {
				$securityConfig = ['enable_authenticator_manager' => true,];
			}
			$container->loadFromExtension('security', [
				...$securityConfig,
				'firewalls'        => [
					'main' => [
						'security' => false,
					],
				],
				'password_hashers' => [
					PasswordAuthenticatedUserInterface::class => [
						'algorithm'   => 'auto',
						'cost'        => 4,
						'time_cost'   => 3,
						'memory_cost' => 10,
					],
				],
			]);

			$container->loadFromExtension('stof_doctrine_extensions', [
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

			$container
				->register('kernel', static::class)
				->setPublic(true)
			;

			$kernelDefinition = $container->getDefinition('kernel');
			$kernelDefinition->addTag('routing.route_loader');

			$loader->load($this->getConfigDir() . '/factories.php');
			$loader->load($this->getConfigDir() . '/fixtures.php');
		});
	}

	public function configureRoutes (RoutingConfigurator $routes): void
	{
		$routes->import($this->getConfigDir() . '/routes.php');

		$routes->add('app_home', '/')->methods(['GET']);
	}

	public function getDatabaseCache (): string
	{
		$dir = $this->getProjectDir() . '/var/cache/database';

		$filesystem = new Filesystem();

		if (!$filesystem->exists($dir)) {
			$filesystem->mkdir($dir);
		}

		return $dir;
	}
}
