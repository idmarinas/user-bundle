<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 31/12/2024, 15:14
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    EmailVerifier.php
 * @date    02/12/2024
 * @time    20:09
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Security;

use Doctrine\ORM\EntityManagerInterface;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final readonly class EmailVerifier
{
	public function __construct (
		private VerifyEmailHelperInterface $verifyEmailHelper,
		private MailerInterface            $mailer,
		private EntityManagerInterface     $entityManager,
		private RequestStack               $requestStack,
	) {}

	public function sendEmailConfirmation (string $verifyEmailRouteName, AbstractUser $user, TemplatedEmail $email): void
	{
		$signatureComponents = $this->verifyEmailHelper->generateSignature(
			$verifyEmailRouteName,
			$user->getId(),
			$user->getEmail()
		);

		$context = $email->getContext();
		$context['signedUrl'] = $signatureComponents->getSignedUrl();
		$context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
		$context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

		$email->context($context);

		try {
			$this->mailer->send($email);
		} catch (TransportExceptionInterface $transportException) {
			$this->requestStack->getSession()->getFlashBag()->add('danger', $transportException->getMessage());
		}
	}

	public function handleEmailConfirmation (Request $request, AbstractUser|UserInterface $user): void
	{
		$this->verifyEmailHelper->validateEmailConfirmationFromRequest($request, $user->getId(), $user->getEmail());

		$user->setVerified(true);

		$this->entityManager->persist($user);
		$this->entityManager->flush();
	}
}
