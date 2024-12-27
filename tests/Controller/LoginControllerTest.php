<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "idmarinas" on 27/12/2024, 12:57
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    LoginControllerTest.php
 * @date    26/12/2024
 * @time    18:41
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Controller;

use DataFixtures\UserFixtures;
use Doctrine\Common\Collections\Criteria;
use Idm\Bundle\User\Tests\App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class LoginControllerTest extends WebTestCase
{
	public function testLogin ()
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/login');

		$this->assertResponseIsSuccessful();

		$this->assertPageTitleContains('Login');

		$client->submitForm('Connect', [
			'_username' => 'john.doe@example.com',
			'_password' => UserFixtures::USER_PASS,
		]);

		$this->assertResponseRedirects('/user/profile');

		$client->followRedirect();
		$this->assertResponseIsSuccessful();
		$this->assertPageTitleContains('Profile of John');

		$client->request(Request::METHOD_GET, '/user/login');

		$this->assertResponseRedirects('/user/profile');
	}

	public function testLoginInvalid ()
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/login');

		$this->assertResponseIsSuccessful();

		$this->assertPageTitleContains('Login');

		$client->submitForm('Connect', [
			'_username' => 'john.doe@example.com',
			'_password' => UserFixtures::USER_PASS . 'dfDyt',
		]);

		$this->assertResponseRedirects('/user/login');
		$client->followRedirect();

		$this->assertSelectorTextContains('form', 'Invalid credentials.');
	}

	public function testLoginChecker ()
	{
		$client = static::createClient();
		/* @var UserRepository $repository */
		$repository = static::getContainer()->get(UserRepository::class);

		$client->request(Request::METHOD_GET, '/user/login');

		$this->assertPageTitleContains('Login');

		/**
		 * User Banned
		 */
		$user = $repository->matching(
			Criteria::create()
				->where(Criteria::expr()->neq('bannedUntil', null))
				->andWhere(Criteria::expr()->isNull('deletedAt'))
				->setMaxResults(1)
		)->first();

		$client->submitForm('Connect', [
			'_username' => $user->getEmail(),
			'_password' => UserFixtures::USER_PASS,
		]);

		$this->assertResponseRedirects('/user/login');
		$client->followRedirect();

		$this->assertSelectorTextContains('form', 'Your user account has been banned');

		/**
		 * User Deleted
		 */
		$user = $repository->matching(
			Criteria::create()
				->where(Criteria::expr()->neq('deletedAt', null))
				->andWhere(Criteria::expr()->isNull('bannedUntil'))
				->setMaxResults(1)
		)->first();

		$client->submitForm('Connect', [
			'_username' => $user->getEmail(),
			'_password' => UserFixtures::USER_PASS,
		]);

		$this->assertResponseRedirects('/user/login');
		$client->followRedirect();

		$this->assertSelectorTextContains('form', 'Your user account no longer exists');

		/**
		 * User Unverified
		 */
		$user = $repository->matching(
			Criteria::create()
				->where(Criteria::expr()->isNull('deletedAt'))
				->andWhere(Criteria::expr()->isNull('bannedUntil'))
				->andWhere(Criteria::expr()->eq('verified', false))
				->setMaxResults(1)
		)->first();

		$client->submitForm('Connect', [
			'_username' => $user->getEmail(),
			'_password' => UserFixtures::USER_PASS,
		]);

		$this->assertResponseRedirects('/user/profile');
		$client->followRedirect();

		$this->assertSelectorTextContains('body', 'You need to verify your email address');
	}
}
