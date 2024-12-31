<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 31/12/2024, 13:53
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ProfileControllerTest.php
 * @date    27/12/2024
 * @time    24:03
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Controller;

use App\Repository\User\UserRepository;
use DataFixtures\UserFixtures;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ProfileControllerTest extends WebTestCase
{

	public function testProfile (): void
	{
		$client = static::createClient();
		$userRepository = static::getContainer()->get(UserRepository::class);

		// retrieve the test user
		$testUser = $userRepository->findOneByEmail(UserFixtures::USER_EMAIL);

		// simulate $testUser being logged in
		$client->loginUser($testUser);

		// test the profile page
		$client->request(Request::METHOD_GET, '/user/profile');
		$this->assertResponseIsSuccessful();
		$this->assertPageTitleContains('Profile of Jane');

		// test if when is authenticated redirect to profile
		$client->request(Request::METHOD_GET, '/user/login');
		$this->assertResponseRedirects('/user/profile');

		$client->request(Request::METHOD_GET, '/logout');
		$this->assertResponseRedirects('/');
	}

	public function testTermsAndConditions (): void
	{
		$client = static::createClient();
		/* @var UserRepository $repository */
		$repository = static::getContainer()->get(UserRepository::class);

		$client->request(Request::METHOD_GET, '/user/profile/accept/terms_and_privacy');

		$this->assertResponseRedirects('/user/login');
		$client->followRedirect();

		// User with accepted privacy and terms
		$user = $repository->matching(
			Criteria::create()
				->where(Criteria::expr()->eq('termsAccepted', true))
				->andWhere(Criteria::expr()->eq('privacyAccepted', true))
				->setMaxResults(1)
		)->first();

		$client->loginUser($user);

		// The privacy policy and terms have been accepted.
		$client->request(Request::METHOD_GET, '/user/profile/accept/terms_and_privacy');

		$this->assertResponseRedirects('/user/profile');

		// User with unaccepted privacy and terms
		$user = $repository->matching(
			Criteria::create()
				->where(Criteria::expr()->eq('termsAccepted', false))
				->andWhere(Criteria::expr()->eq('privacyAccepted', false))
				->setMaxResults(1)
		)->first();

		$client->loginUser($user);

		// The privacy policy and terms have been accepted.
		$client->request(Request::METHOD_GET, '/user/profile/accept/terms_and_privacy');

		$this->assertPageTitleContains('Acceptance of terms and conditions');
	}

	public function testChangePassword (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/login');
		$client->submitForm('Connect', [
			'_username' => UserFixtures::USER_EMAIL,
			'_password' => UserFixtures::USER_PASS,
		]);

		$client->request(Request::METHOD_GET, '/user/profile/change/password');

		$this->assertPageTitleContains('Change password');

		$client->submitForm('Change password', [
			'change_password_form[currentPassword]'       => UserFixtures::USER_PASS,
			'change_password_form[plainPassword][first]'  => UserFixtures::USER_PASS . 'new',
			'change_password_form[plainPassword][second]' => UserFixtures::USER_PASS . 'new',
		]);

		$this->assertResponseRedirects('/user/profile');

		$client->request(Request::METHOD_GET, '/logout');
		$this->assertResponseRedirects('/');

		$client->request(Request::METHOD_GET, '/user/login');

		$client->submitForm('Connect', [
			'_username' => UserFixtures::USER_EMAIL,
			'_password' => UserFixtures::USER_PASS,
		]);

		$this->assertResponseRedirects('/user/login');
		$client->followRedirect();

		$this->assertSelectorTextContains('body', 'Invalid credentials.');

		$client->request(Request::METHOD_GET, '/user/login');
		$client->submitForm('Connect', [
			'_username' => UserFixtures::USER_EMAIL,
			'_password' => UserFixtures::USER_PASS . 'new',
		]);

		$this->assertResponseRedirects('/user/profile');
	}

	public function testDeleteUser (): void
	{
		$client = static::createClient();

		$client->request(Request::METHOD_GET, '/user/login');

		$client->submitForm('Connect', [
			'_username' => UserFixtures::USER_EMAIL,
			'_password' => UserFixtures::USER_PASS,
		]);

		$client->request(Request::METHOD_GET, '/user/profile/delete');

		$this->assertPageTitleContains('Delete account Jane');

		$client->clickLink('No');

		$this->assertResponseIsSuccessful();
		$this->assertPageTitleContains('Profile of Jane');

		$client->request(Request::METHOD_GET, '/user/profile/delete');

		$client->submitForm('Yes', ['token' => 'false-token']);

		$this->assertResponseRedirects('/user/profile');
		$client->followRedirect();
		$this->assertPageTitleContains('Profile of Jane');
		$this->assertSelectorTextContains('body', 'The form is invalid, please try again.');

		$client->request(Request::METHOD_GET, '/user/profile/delete');

		$client->submitForm('Yes');

		$this->assertResponseRedirects('/logout');

		$userRepository = static::getContainer()->get(UserRepository::class);

		// retrieve the test user
		$user = $userRepository->findOneByEmail(UserFixtures::USER_EMAIL);
		$this->assertNull($user);
	}
}
