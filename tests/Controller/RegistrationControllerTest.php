<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 31/12/2024, 16:57
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
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use function Zenstruck\Foundry\faker;

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
			'registration_form[email]'                          => UserFixtures::USER_TEST_EMAIL,
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
			'registration_form[email]'                          => UserFixtures::USER_TEST_EMAIL,
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
			'registration_form[email]'                          => UserFixtures::USER_TEST_EMAIL,
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
			'registration_form[email]'                          => UserFixtures::USER_TEST_EMAIL,
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
			'registration_form[email]'                          => UserFixtures::USER_TEST_EMAIL,
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

		$this->assertEmailAddressContains($email, 'to', UserFixtures::USER_TEST_EMAIL);
		$this->assertEmailHeaderSame($email, 'subject', 'Please confirm your email address');
		$this->assertEmailHtmlBodyContains($email, 'http://localhost/user/registration/verify/email?expires=');
		$this->assertEmailHtmlBodyContains(
			$email,
			'This link will expire in 1 hour, login is required to verify the email'
		);
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

		$client->getRequest()->getSession();
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
