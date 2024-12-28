<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 28/12/2024, 12:15
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    RegistrationControllerTest.php
 * @date    27/12/2024
 * @time    18:32
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Controller;

use DataFixtures\UserFixtures;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;

class RegistrationControllerTest extends WebTestCase
{
	public function testWebRegistration (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/registration/register');

		$this->assertResponseIsSuccessful();
		$this->assertPageTitleContains('Registration');

		$client->clickLink('Already have an account? Log in');

		$this->assertResponseIsSuccessful();
		$this->assertPageTitleContains('Login');

		$client->request(Request::METHOD_GET, '/user/registration/register');

		$client->submitForm('registration_form_button', [
			'registration_form[email]'                          => UserFixtures::USER_EMAIL,
			'registration_form[plainPassword][password]'        => UserFixtures::USER_PASS,
			'registration_form[plainPassword][password_repeat]' => UserFixtures::USER_PASS,
			'registration_form[termsAccepted]'                  => true,
			'registration_form[privacyAccepted]'                => true,
		]);

		$this->assertResponseRedirects('http://localhost/user/profile');

		// An email must have been sent
		$this->assertEmailCount(1);
		$email = $this->getMailerMessage();

		$client->followRedirect();
		$this->assertPageTitleContains('Profile of');

		$client->request(Request::METHOD_GET, '/user/registration/register');

		$this->assertResponseRedirects('/user/profile');
	}

	public function testWebRegistrationFail (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/registration/register');

		$this->assertResponseIsSuccessful();
		$this->assertPageTitleContains('Registration');

		$client->submitForm('registration_form_button', [
			'registration_form[email]'                          => UserFixtures::USER_EMAIL,
			'registration_form[plainPassword][password]'        => UserFixtures::USER_PASS,
			'registration_form[plainPassword][password_repeat]' => UserFixtures::USER_PASS,
			'registration_form[termsAccepted]'                  => false,
			'registration_form[privacyAccepted]'                => true,
		]);

		$this->assertResponseIsUnprocessable();

		// No email must have been sent
		$this->assertEmailCount(0);
	}

	public function testVerifyEmailLink (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/registration/register');

		$client->submitForm('registration_form_button', [
			'registration_form[email]'                          => UserFixtures::USER_EMAIL,
			'registration_form[plainPassword][password]'        => UserFixtures::USER_PASS,
			'registration_form[plainPassword][password_repeat]' => UserFixtures::USER_PASS,
			'registration_form[termsAccepted]'                  => true,
			'registration_form[privacyAccepted]'                => true,
		]);

		$this->assertResponseRedirects('http://localhost/user/profile');

		// An email must have been sent
		$this->assertEmailCount(1);

		/** @var TemplatedEmail $email */
		$email = $this->getMailerMessage();
		$crawler = new Crawler($email->getHtmlBody());
		$link = $crawler->selectLink('Confirm my email')->link()->getUri();

		$client->followRedirect();
		$this->assertResponseIsSuccessful();

		$client->request(Request::METHOD_GET, str_replace('http://localhost', '', $link));

		$this->assertResponseRedirects('/user/profile');

		$client->followRedirect();

		$this->assertResponseIsSuccessful();
	}

	public function testVerifyEmailLinkFail (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/registration/register');

		$client->submitForm('registration_form_button', [
			'registration_form[email]'                          => UserFixtures::USER_EMAIL,
			'registration_form[plainPassword][password]'        => UserFixtures::USER_PASS,
			'registration_form[plainPassword][password_repeat]' => UserFixtures::USER_PASS,
			'registration_form[termsAccepted]'                  => true,
			'registration_form[privacyAccepted]'                => true,
		]);

		$this->assertResponseRedirects('http://localhost/user/profile');

		// An email must have been sent
		$this->assertEmailCount(1);

		/** @var TemplatedEmail $email */
		$email = $this->getMailerMessage();
		$crawler = new Crawler($email->getHtmlBody());
		$link = $crawler->selectLink('Confirm my email')->link()->getUri();

		$client->followRedirect();
		$this->assertResponseIsSuccessful();

		$client->request(Request::METHOD_GET, str_replace('http://localhost', '', $link) . 'fail');

		$this->assertResponseRedirects('/');

		$client->followRedirect();

		$this->assertResponseIsSuccessful();
		$this->assertPageTitleContains('IDMarinas User Bundle');
		$this->assertSelectorTextContains('body', 'The link to verify your email is invalid. Please request a new link.');
	}

	public function testVerifyEmail (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/registration/register');

		$client->submitForm('registration_form_button', [
			'registration_form[email]'                          => UserFixtures::USER_EMAIL,
			'registration_form[plainPassword][password]'        => UserFixtures::USER_PASS,
			'registration_form[plainPassword][password_repeat]' => UserFixtures::USER_PASS,
			'registration_form[termsAccepted]'                  => true,
			'registration_form[privacyAccepted]'                => true,
		]);

		$this->assertResponseRedirects('http://localhost/user/profile');

		// An email must have been sent
		$this->assertEmailCount(1);
		/** @var TemplatedEmail $email */
		$email = $this->getMailerMessage();

		$this->assertEmailAddressContains($email, 'to', UserFixtures::USER_EMAIL);
		$this->assertEmailHeaderSame($email, 'subject', 'Please confirm your email address');
		$this->assertEmailHtmlBodyContains($email, 'http://localhost/user/registration/verify/email?expires=');
		$this->assertEmailHtmlBodyContains(
			$email,
			'This link will expire in 1 hour, login is required to verify the email'
		);
	}
}
