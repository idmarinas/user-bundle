<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 31/12/2024, 13:55
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ProfileController.php
 * @date    26/12/2024
 * @time    21:10
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Idm\Bundle\User\Form\ChangePasswordFormType;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Idm\Bundle\User\Model\Repository\AbstractUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use function Symfony\Component\Translation\t;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
#[Route(path: '/profile', name: 'profile_')]
final class ProfileController extends AbstractController
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
		$form = $this->createForm(ChangePasswordFormType::class, $user);
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
	public function deleteUserAccount (Request $request, EntityManagerInterface $entityManager): Response
	{
		$token = $request->request->get('token');

		if ($this->isCsrfTokenValid('delete-user', $token)) {
			$entityManager->remove($this->getUser());
			$entityManager->flush();

			return $this->redirectToRoute('_logout_main');
		}

		$this->addFlash('error', t('flash.error.delete_user.csrf', [], 'IdmUserBundle'));

		return $this->redirectToRoute('idm_user_profile_index');
	}
}
