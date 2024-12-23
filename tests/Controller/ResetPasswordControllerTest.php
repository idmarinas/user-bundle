<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/12/2024, 16:55
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ResetPasswordControllerTest.php
 * @date    16/12/2024
 * @time    21:56
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ResetPasswordControllerTest extends WebTestCase
{
	public function testRecoverPassword (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/reset-password');

		$this->assertResponseIsSuccessful();
		$this->assertSelectorTextContains('h1', 'Reset your password');
		$this->assertPageTitleContains('Reset your password');

		$client->submitForm('reset_password_request_form_button', [
			'reset_password_request_form[email]' => 'john.doe@example.com',
		]);

		$this->assertResponseRedirects('/user/reset-password/check-email');

		// An email has to be queued
//		$this->assertQueuedEmailCount(1);

		/** @var TemplatedEmail $email */
		$email = $this->getMailerMessage();
		$re = '/(http:\/\/localhost\/user\/reset-password\/reset\/\w+)/m';
		preg_match_all($re, $email->getHtmlBody(), $matches, PREG_SET_ORDER);
		$link = $matches[0][0];

		$this->assertEmailAddressContains($email, 'to', 'john.doe@example.com');
		$this->assertEmailHeaderSame($email, 'subject', 'Your password reset request');
		$this->assertEmailHtmlBodyContains($email, 'http://localhost/user/reset-password/reset/');

		$client->followRedirect();

		$this->assertResponseIsSuccessful();
		$this->assertSelectorTextContains('body', 'If you don\'t receive an email please check your spam folder');

		$client->request(Request::METHOD_GET, str_replace('http://localhost', '', $link));

		$this->assertResponseRedirects('/user/reset-password/reset');

		$client->followRedirect();

		$this->assertResponseIsSuccessful();

		$client->submitForm('reset_password_form_button', [
			'reset_password_form[plainPassword][first]'  => 'pass_123456',
			'reset_password_form[plainPassword][second]' => 'pass_123456',
		]);

		$this->assertResponseRedirects('/');
	}

	public function testRecoverPasswordNotFoundEmail (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/reset-password');

		$this->assertResponseIsSuccessful();
		$this->assertSelectorTextContains('h1', 'Reset your password');
		$this->assertPageTitleContains('Reset your password');

		$client->submitForm('reset_password_request_form_button', [
			'reset_password_request_form[email]' => 'fake@faker.fk',
		]);

		$this->assertResponseRedirects('/user/reset-password/check-email');

		// Ningún email tiene que estar en cola
		$this->assertQueuedEmailCount(0);
	}

	public function testCheckEmail (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/reset-password/check-email');

		// Forced to create a fake token
		$this->assertPageTitleContains('Password Reset Email Sent');
	}

	public function testResetPassword (): void
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/reset-password/reset');

		$this->assertResponseStatusCodeSame(404);
		$this->assertPageTitleContains('No reset password token found in the URL or in the session.');

		$client->request(Request::METHOD_GET, '/user/reset-password/reset/Bi7T4wO5w8uOsIvEnIJSa73mEbqFu5Wj9Kx1');

		$this->assertResponseRedirects('/user/reset-password/reset');
		$client->followRedirect();

		$this->assertResponseRedirects('/user/reset-password');
		$client->followRedirect();

		$this->assertSelectorTextContains('h1', 'Reset your password');
		$this->assertSelectorTextContains('body', 'There was a problem validating your password reset request');
	}

	public function testTooManyResets (): void
	{
		$client = self::createClient();
		$client->request(Request::METHOD_GET, '/user/reset-password');
		$this->assertResponseIsSuccessful();

		$client->submitForm('reset_password_request_form_button', [
			'reset_password_request_form[email]' => 'john.doe@example.com',
		]);
		$this->assertResponseRedirects('/user/reset-password/check-email');

		$client->request(Request::METHOD_GET, '/user/reset-password');
		$this->assertResponseIsSuccessful();

		$client->submitForm('reset_password_request_form_button', [
			'reset_password_request_form[email]' => 'john.doe@example.com',
		]);
		$this->assertResponseRedirects('/user/reset-password/check-email');
	}
}
