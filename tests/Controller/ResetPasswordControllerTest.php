<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 01/01/2025, 18:29
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

use App\Repository\User\UserRepository;
use DataFixtures\UserFixtures;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Factory\UserFactory;
use Idm\Bundle\User\Controller\ResetPasswordController;
use ReflectionException;
use ReflectionMethod;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use function Zenstruck\Foundry\faker;

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

		// An email must have been sent
		$this->assertEmailCount(1);

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

	public function testAuthenticatedUser (): void
	{
		$client = static::createClient();
		$repository = static::getContainer()->get(UserRepository::class);

		$user = $repository->findOneByEmail(UserFixtures::USER_EMAIL);

		$client->loginUser($user);

		$client->request(Request::METHOD_GET, '/user/reset-password');
		$this->assertResponseRedirects('/user/profile');

		$client->request(Request::METHOD_GET, '/user/reset-password/reset');
		$this->assertResponseRedirects('/user/profile');

		$client->request(Request::METHOD_GET, '/user/reset-password/check-email');
		$this->assertResponseRedirects('/user/profile');
	}

	/**
	 * @throws ReflectionException
	 */
	public function testProcessSendingPasswordResetEmailThrowsException ()
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/registration/register');
		$mailer = $this->createMock(MailerInterface::class);
		$translator = $this->createMock(TranslatorInterface::class);
		$entityManager = $this->createMock(EntityManagerInterface::class);
		$repository = $this->createMock(UserRepository::class);
		$helper = $this->createMock(ResetPasswordHelperInterface::class);

		$token = new ResetPasswordToken(
			faker()->sha1(), new DateTime('+10 years'), (new DateTime('now'))->getTimestamp()
		);
		$helper->method('generateResetToken')->willReturn($token);
		$repository->method('findOneBy')->willReturn(UserFactory::createOne()->_real());
		$entityManager->method('getRepository')->willReturn($repository);

		$mailer
			->method('send')
			->will($this->throwException(new TransportException()))
		;

		$requestStack = static::getContainer()->get('request_stack');
		$requestStack->push($client->getRequest());

		$container = new Container();
		$container->set('mailer', $mailer);
		$container->set('translator', $translator);
		$container->set('request_stack', $requestStack);
		$container->set('router', static::getContainer()->get('router'));

		$controller = new ResetPasswordController($helper, $entityManager);
		$controller->setContainer($container);

		$method = new ReflectionMethod($controller, 'processSendingPasswordResetEmail');

		$response = $method->invoke($controller, 'test@example.com', $mailer, $translator);

		$this->assertInstanceOf(RedirectResponse::class, $response);
		$this->assertEquals('/user/reset-password/reset', $response->getTargetUrl());
	}
}
