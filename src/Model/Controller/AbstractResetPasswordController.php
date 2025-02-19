<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/02/2025, 23:21
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractResetPasswordController.php
 * @date    10/12/2024
 * @time    12:06
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Model\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use function Symfony\Component\Translation\t;

abstract class AbstractResetPasswordController extends AbstractController
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
	): Response {
		if ($this->getUser() instanceof UserInterface) {
			return $this->redirectToRoute('idm_user_profile_index');
		}

		$form = $this->getResetPasswordRequestForm();
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			/** @var string $email */
			$email = $form->get('email')->getData();

			return $this->processSendingPasswordResetEmail($email, $mailer, $translator);
		}

		return $this->render('@IdmUser/reset_password/request.html.twig', [
			'form' => $form,
		]);
	}

	/**
	 * Confirmation page after a user has requested a password reset.
	 */
	#[Route('/check-email', name: 'check_email', methods: ['GET'])]
	public function checkEmail (): Response
	{
		if ($this->getUser() instanceof UserInterface) {
			return $this->redirectToRoute('idm_user_profile_index');
		}

		// Generate a fake token if the user does not exist or someone hit this page directly.
		// This prevents exposing whether or not a user was found with the given email address or not
		if (!($resetToken = $this->getTokenObjectFromSession()) instanceof ResetPasswordToken) {
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
		?string                     $token = null
	): Response {
		if ($this->getUser() instanceof UserInterface) {
			return $this->redirectToRoute('idm_user_profile_index');
		}

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
			/** @var AbstractUser $user */
			$user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
		} catch (ResetPasswordExceptionInterface $resetPasswordException) {
			$this->addFlash(
				'reset_password_error',
				sprintf(
					'%s - %s',
					t(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_VALIDATE, [], 'ResetPasswordBundle'),
					t($resetPasswordException->getReason(), [], 'ResetPasswordBundle')
				)
			);

			return $this->redirectToRoute('idm_user_forgot_password_request');
		}

		// The token is valid; allow the user to change their password.
		$form = $this->getResetPasswordForm();
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

		return $this->render('@IdmUser/reset_password/reset.html.twig', [
			'form' => $form,
		]);
	}

	protected abstract function getResetPasswordRequestForm (?object $data = null, array $options = []): FormInterface;

	protected abstract function getResetPasswordForm (?object $data = null, array $options = []): FormInterface;

	private function processSendingPasswordResetEmail (
		string              $emailFormData,
		MailerInterface     $mailer,
		TranslatorInterface $translator
	): RedirectResponse {
		$user = $this->entityManager->getRepository(AbstractUser::class)->findOneBy([
			'email' => $emailFormData,
		]);

		// Do not reveal whether a user account was found or not.
		if ($user === null) {
			return $this->redirectToRoute('idm_user_check_email');
		}

		try {
			$resetToken = $this->resetPasswordHelper->generateResetToken($user);
		} catch (ResetPasswordExceptionInterface) {
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
			->to((string)$user->getEmail())
			->subject($translator->trans('email.reset_password.subject', domain: 'IdmUserBundle'))
			->htmlTemplate('@IdmUser/reset_password/email.html.twig')
			->textTemplate('@IdmUser/reset_password/email.txt.twig')
			->context([
				'resetToken' => $resetToken,
			])
			->locale($translator->getLocale())
		;

		try {
			$mailer->send($email);
		} catch (TransportExceptionInterface $transportException) {
			$this->addFlash(
				'error',
				t('flash.error.email.send', ['message' => $transportException->getMessage()], 'IdmUserBundle')
			);

			return $this->redirectToRoute('idm_user_reset_password');
		}

		// Store the token object in session for retrieval in check-email route.
		$this->setTokenObjectInSession($resetToken);

		return $this->redirectToRoute('idm_user_check_email');
	}
}
