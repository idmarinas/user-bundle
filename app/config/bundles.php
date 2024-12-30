<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 30/12/2024, 15:45
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    bundles.php
 * @date    30/12/2024
 * @time    15:40
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

use DAMA\DoctrineTestBundle\DAMADoctrineTestBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Idm\Bundle\User\IdmUserBundle;
use Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use SymfonyCasts\Bundle\ResetPassword\SymfonyCastsResetPasswordBundle;
use SymfonyCasts\Bundle\VerifyEmail\SymfonyCastsVerifyEmailBundle;
use Zenstruck\Foundry\ZenstruckFoundryBundle;

return [
	FrameworkBundle::class                 => ['all' => true],
	DoctrineBundle::class                  => ['all' => true],
	SymfonyCastsVerifyEmailBundle::class   => ['all' => true],
	SymfonyCastsResetPasswordBundle::class => ['all' => true],
	TwigBundle::class                      => ['all' => true],
	SecurityBundle::class                  => ['all' => true],
	StofDoctrineExtensionsBundle::class    => ['all' => true],
	IdmUserBundle::class                   => ['all' => true],

	// Dev-Test Bundles
	DoctrineFixturesBundle::class          => ['all' => true],
	DAMADoctrineTestBundle::class          => ['all' => true],
	ZenstruckFoundryBundle::class          => ['all' => true],
];
