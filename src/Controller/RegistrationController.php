<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 29/12/2024, 17:51
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    RegistrationController.php
 * @date    28/12/2024
 * @time    12:14
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\User\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Idm\Bundle\User\Form\RegistrationFormType;
use Idm\Bundle\User\Security\EmailVerifier;
use Idm\Bundle\User\Traits\Controller\RegistrationTrait;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use function Symfony\Component\Translation\t;

#[Route(path: '/registration', name: 'registration_')]
final class RegistrationController extends AbstractController
{
	use RegistrationTrait;

	public function __construct (
		private readonly EmailVerifier               $emailVerifier,
		private readonly EntityManagerInterface      $entityManager,
		private readonly TranslatorInterface         $translator,
		private readonly UserPasswordHasherInterface $passwordHasher,
	) {}

	#[Route('/register', name: 'register_web', methods: ['GET', 'POST'])]
	public function registerWeb (
		Request  $request,
		Security $security,
	): Response {
		if ($this->getUser() instanceof UserInterface) {
			return $this->redirectToRoute('idm_user_profile_index');
		}

		$user = $this->getUserObject();

		$form = $this->createForm(RegistrationFormType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$templateEmail = (new TemplatedEmail())->locale($request->getLocale());
			$this->registerUser($user, $templateEmail, $form->get('plainPassword')->getData());

			return $security->login($user, 'form_login');
		}

		return $this->render('@IdmUser/registration/register.html.twig', [
			'form' => $form,
		]);
	}

	#[Route(path: '/verify/email', name: 'verify_email', methods: ['GET'])]
	public function verifyUserEmail (Request $request): Response
	{
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

		// validate email confirmation link, sets User::isVerified=true and persists
		try {
			$this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
		} catch (VerifyEmailExceptionInterface $exception) {
			$this->addFlash('error', t($exception->getReason(), [], 'VerifyEmailBundle'));

			return $this->redirectToRoute('app_home');
		}

		$this->addFlash('success', t('flash.success.email_verified', [], 'IdmUserBundle'));

		return $this->redirectToRoute('idm_user_profile_index');
	}
}
