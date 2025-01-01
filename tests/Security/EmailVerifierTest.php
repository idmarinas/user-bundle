<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 01/01/2025, 19:30
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    EmailVerifierTest.php
 * @date    31/12/2024
 * @time    16:58
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Security;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Factory\UserFactory;
use Idm\Bundle\User\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Translation\TranslatableMessage;
use SymfonyCasts\Bundle\VerifyEmail\Model\VerifyEmailSignatureComponents;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Zenstruck\Foundry\Test\Factories;
use function Zenstruck\Foundry\faker;

class EmailVerifierTest extends WebTestCase
{
	use Factories;

	public function testEmailVerifier ()
	{
		$client = static::createClient();
		$client->request(Request::METHOD_GET, '/user/registration/register');

		$requestStack = static::getContainer()->get('request_stack');
		$requestStack->push($client->getRequest());

		$verifyHelper = $this->createMock(VerifyEmailHelperInterface::class);
		$mailer = $this->createMock(MailerInterface::class);
		$entityManager = $this->createMock(EntityManagerInterface::class);

		$signature = new VerifyEmailSignatureComponents(
			new DateTime('+2 days'),
			faker()->url(),
			(new Datetime('now'))->getTimestamp()
		);

		$verifyHelper->method('generateSignature')->willReturn($signature);

		$mailer
			->method('send')
			->will($this->throwException(new TransportException()))
		;

		$user = UserFactory::createOne()->_real();
		$templatedEmail = (new TemplatedEmail())
			->locale('en')
		;
		$emailVerifier = new EmailVerifier($verifyHelper, $mailer, $entityManager, $requestStack);

		$emailVerifier->sendEmailConfirmation('idm_user_registration_verify_email', $user, $templatedEmail);

		$messages = $requestStack->getSession()->getFlashBag()->all();
		$this->assertNotEmpty($messages);
		$this->assertArrayHasKey('error', $messages);
		$this->assertInstanceOf(TranslatableMessage::class, $messages['error'][0]);
	}
}
