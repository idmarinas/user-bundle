<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/12/2024, 19:48
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ResetPasswordController.php
 * @date    10/12/2024
 * @time    12:06
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Idm\Bundle\User\Form\ResetPasswordFormType;
use Idm\Bundle\User\Form\ResetPasswordRequestFormType;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use Twig\Environment;

#[AsController]
#[Route('/reset-password')]
final class ResetPasswordController extends AbstractController
{
	use ResetPasswordControllerTrait;

	public function __construct (
		private readonly ResetPasswordHelperInterface $resetPasswordHelper,
		private readonly EntityManagerInterface       $entityManager
	) {}

	#[Route('', name: 'forgot_password_request', methods: ['GET', 'POST'])]
	public function request (
		Request             $request,
		MailerInterface     $mailer,
		TranslatorInterface $translator,
		Environment         $twig,
	): Response {
		$form = $this->createForm(ResetPasswordRequestFormType::class);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			/** @var string $email */
			$email = $form->get('email')->getData();

			return $this->processSendingPasswordResetEmail($email, $mailer, $twig, $translator);
		}

		return $this->renderForm('@IdmUser/reset_password/request.html.twig', [
			'form' => $form,
		]);
	}

	/**
	 * Confirmation page after a user has requested a password reset.
	 */
	#[Route('/check-email', name: 'check_email', methods: ['GET'])]
	public function checkEmail (): Response
	{
		// Generate a fake token if the user does not exist or someone hit this page directly.
		// This prevents exposing whether or not a user was found with the given email address or not
		if (null === ($resetToken = $this->getTokenObjectFromSession())) {
			$resetToken = $this->resetPasswordHelper->generateFakeResetToken();
		}

		return $this->render('@IdmUser/reset_password/check_email.html.twig', [
			'resetToken' => $resetToken,
		]);
	}

	/**
	 * Validates and process the reset URL that the user clicked in their email.
	 */
	#[Route('/reset/{token}', name: 'reset_password', methods: ['GET', 'POST'])]
	public function reset (
		Request                     $request,
		UserPasswordHasherInterface $passwordHasher,
		TranslatorInterface         $translator,
		?string                     $token = null
	): Response {
		if ($token) {
			// We store the token in session and remove it from the URL, to avoid the URL being
			// loaded in a browser and potentially leaking the token to 3rd party JavaScript.
			$this->storeTokenInSession($token);

			return $this->redirectToRoute('idm_user_reset_password');
		}

		$token = $this->getTokenFromSession();

		if (null === $token) {
			throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
		}

		try {
			/** @var PasswordAuthenticatedUserInterface $user */
			$user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
		} catch (ResetPasswordExceptionInterface $e) {
			$this->addFlash(
				'reset_password_error',
				sprintf(
					'%s - %s',
					$translator->trans(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_VALIDATE, [], 'ResetPasswordBundle'),
					$translator->trans($e->getReason(), [], 'ResetPasswordBundle')
				)
			);

			return $this->redirectToRoute('idm_user_forgot_password_request');
		}

		// The token is valid; allow the user to change their password.
		$form = $this->createForm(ResetPasswordFormType::class);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// A password reset token should be used only once, remove it.
			$this->resetPasswordHelper->removeResetRequest($token);

			/** @var string $plainPassword */
			$plainPassword = $form->get('plainPassword')->getData();

			// Encode(hash) the plain password, and set it.
			$user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
			$this->entityManager->flush();

			// The session is cleaned up after the password has been changed.
			$this->cleanSessionAfterReset();

			return $this->redirectToRoute('app_home');
		}

		return $this->renderForm('@IdmUser/reset_password/reset.html.twig', [
			'form' => $form,
		]);
	}

	private function processSendingPasswordResetEmail (
		string              $emailFormData,
		MailerInterface     $mailer,
		Environment         $twig,
		TranslatorInterface $translator
	): RedirectResponse {
		$user = $this->entityManager->getRepository(AbstractUser::class)->findOneBy([
			'email' => $emailFormData,
		]);

		// Do not reveal whether a user account was found or not.
		if (!$user) {
			return $this->redirectToRoute('idm_user_check_email');
		}

		try {
			$resetToken = $this->resetPasswordHelper->generateResetToken($user);
		} catch (ResetPasswordExceptionInterface $e) {
			// If you want to tell the user why a reset email was not sent, uncomment
			// the lines below and change the redirect to 'forgot_password_request'.
			// Caution: This may reveal if a user is registered or not.
			//
			// $this->addFlash('reset_password_error', sprintf(
			//     '%s - %s',
			//     $translator->trans(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_HANDLE, [], 'ResetPasswordBundle'),
			//     $translator->trans($e->getReason(), [], 'ResetPasswordBundle')
			// ));

			return $this->redirectToRoute('idm_user_check_email');
		}

		$email = (new TemplatedEmail())
			->from(new Address('mailer@example.com', 'Acme Mail Bot'))
			->to((string)$user->getEmail())
			->subject('Your password reset request')
			->html($twig->render('@IdmUser/reset_password/email.html.twig', ['resetToken' => $resetToken,]))
		;

		$mailer->send($email);

		// Store the token object in session for retrieval in check-email route.
		$this->setTokenObjectInSession($resetToken);

		return $this->redirectToRoute('idm_user_check_email');
	}
}
