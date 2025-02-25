<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/02/2025, 23:15
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractProfileController.php
 * @date    26/12/2024
 * @time    21:10
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Model\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Idm\Bundle\User\Model\Repository\AbstractUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\Translation\t;

abstract class AbstractProfileController extends AbstractController
{
	#[Route(name: 'index', methods: ['GET'])]
	public function index (): Response
	{
		return $this->render('@IdmUser/profile/index.html.twig');
	}

	#[Route(path: '/change/password', name: 'change_password', methods: ['GET', 'POST'])]
	public function changePassword (
		Request                     $request,
		EntityManagerInterface      $entityManager,
		UserPasswordHasherInterface $passwordHasher
	): Response {
		/** @var AbstractUser $user */
		$user = $this->getUser();
		$form = $this->getChangePasswordForm($user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			/* @var AbstractUserRepository $repository */
			$repository = $entityManager->getRepository(AbstractUser::class);
			$repository->upgradePassword($user, $passwordHasher->hashPassword($user, $form->get('plainPassword')->getData()));

			return $this->redirectToRoute('idm_user_profile_index');
		}

		return $this->render('@IdmUser/profile/change_password.html.twig', [
			'form' => $form,
		]);
	}

	#[Route(path: '/accept/terms_and_privacy', name: 'accept_terms_privacy', methods: ['GET'])]
	public function acceptTermsPrivacy (): Response
	{
		/* @var AbstractUser $user */
		$user = $this->getUser();
		if ($user->getPrivacyAccepted() && $user->getTermsAccepted()) {
			$this->addFlash('warning', t('flash.warning.privacy_terms_accepted', domain: 'IdmUserBundle'));

			return $this->redirectToRoute('idm_user_profile_index');
		}

		return $this->render('@IdmUser/profile/accept_terms_privacy.html.twig');
	}

	#[Route(path: '/delete', name: 'delete_user', methods: ['GET'])]
	public function deleteUser (): Response
	{
		return $this->render('@IdmUser/profile/delete.html.twig');
	}

	#[Route(path: '/delete/confirm', name: 'delete_user_confirm', methods: ['POST'])]
	public function deleteUserAccount (
		Request                $request,
		EntityManagerInterface $entityManager,
		Security               $security
	): Response {
		$token = $request->request->get('token');

		if ($this->isCsrfTokenValid('delete-user', $token)) {
			$entityManager->remove($this->getUser());
			$entityManager->flush();

			$security->logout(false);

			$this->addFlash('success', t('flash.success.delete_user_confirm', domain: 'IdmUserBundle'));

			return $this->redirectToRoute('idm_user_registration_register_web');
		}

		$this->addFlash('error', t('flash.error.delete_user.csrf', [], 'IdmUserBundle'));

		return $this->redirectToRoute('idm_user_profile_index');
	}

	protected abstract function getChangePasswordForm (?object $data = null, array $options = []): FormInterface;
}
